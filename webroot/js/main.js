class CsvValidator {

    nthIndexOf = (s, t, n) => s.split(t, n).join(t).length;

    // Patterns for id, number, country, start_time, connect_time, end_time, score, url
    rules = [
        /^\d{1,11}_\d{1,5}_\d{1,5}$/g,
        /^\d{1,20}$/g,
        /^[A-Za-z\s]{1,100}$/g,
        /^\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}$/g,
        /^\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}$/g,
        /^\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}$/g,
        /^\d\.\d{1,2}$/g,
        /^https?:\/\/.*/g
    ];

    fieldCount = this.rules.length;

    msgs = {    // as per specification
        // Note:  line_no + 1 accounts for stripped header row
        wrong_length_row:   (line_no, field_count, expected_count) => `On line ${line_no + 1}: Found ${field_count} columns, expecting ${expected_count} columns`,
        empty_field:        (line_no, column_no) => `On line ${line_no + 1}, column ${column_no}: required field missing`,
        bad_format:         (line_no, column_no, field_value) => `On line ${line_no + 1}, column ${column_no}: Found ‘${field_value}’ which has an unexpected format.`,
        duplicate_id:       line_no => `On line ${line_no + 1}: Row already defined in file previously`,
    }

    
    constructor(csv_file_data) {
        this.data = csv_file_data;
        this.ids = [];   // keep list of ids so we can check for duplicates
    }

    validateField(field, rule) {
        // return true or false depending on whether string value in field matches the pattern in rule
        let match_array = field.match(rule);
        if (!match_array || match_array.length != 1) {
            return false;
        }
        return match_array[0] == field;
    }

    validateRow(row, row_index, rules) {
        let row_msgs = [];
        const fields = row.split(`,`);
        // First allow an extra row on the end with no printable chars - or any empty row:
        if (fields.length == 1 && fields[0] == ``) {
            return [];
        }
        // Next, check for short or long rows
        if (fields.length != this.fieldCount) {
            return [this.msgs.wrong_length_row(row_index, fields.length, this.fieldCount)];
        }
        fields.forEach((field, field_index) => {
            // check not null
            if (!field) {
                row_msgs.push(this.msgs.empty_field(row_index, row.search(/,\s*,/g))); 
            }
            else {
                if (field_index == 7) {     // strip off Microsoft CR (`\r`) character from last field:
                    field = field.replace(`\r`, ``);
                }
                else if (field_index == 0) {
                    // Test for duplicate ids:
                    if (this.ids.includes(field)) {
                        row_msgs.push(this.msgs.duplicate_id(row_index));
                    }
                    else {
                        // add to ids array so we can check for duplicates
                        this.ids.push(field);
                    }
                }
                if (!this.validateField(field, rules[field_index])) {
                    row_msgs.push(this.msgs.bad_format(row_index, this.nthIndexOf(row, `,`, field_index), field));       
                }
            }
        });
        return row_msgs;    // if no errors detected, this will be an empty array
    }

    validateFile() {
        let file_msgs = [];
        // Leave out first row (header);
        let rows = this.data.split(`\n`).slice(1);
        rows.forEach((row, row_index) => {
            file_msgs.push(...this.validateRow(row, row_index, this.rules));
        });
        return file_msgs;
    }
}
// End Class CsvValidator

// Main top-level code:

const csv_import_form = document.getElementById('upload-form');
const csv_file_chooser = document.getElementById('csv-input');
const csv_submit_btn = document.getElementById('csv-submit');
const msgs = document.getElementsByClassName(`message`);
const error_list = document.getElementById('errors');
// const upload_form = document.getElementById(`upload-form`);
const user_edit_form = document.getElementById(`user-edit-form`);

document.onreadystatechange = _ => {
  if (document.readyState === `complete`) {
    if(document.URL.indexOf(`results`) != -1) {
      csv_submit_btn.addEventListener('click', handleFileSelect, false);
    }
    fade(msgs);
    // Code to save user info and prepopulate User Profile modal when User Name is clicked top right
    let user = eval(decodeURIComponent(document.cookie).slice(5));
    let username = user[0].replace(`+`, ` `);
    document.getElementById(`edit-profile`).addEventListener('click', ev => {
        document.getElementById(`self-edit-name`).value = username;
        document.getElementById(`self-edit-email`).value = user[1];
        document.getElementById(`self-edit-status`).value = user[2];
        document.getElementById(`self-edit-password`).value = ``;
        document.getElementById(`self-edit-confirm-password`).value = ``;
    });
  };
};
// End top-level code


// FUNCTIONS:

function fade(elems, delay = 2, interval = 0.1, step = 0.1) {
  // delay (before fade starts) in seconds
  // step (reduction in opacity per step)
  // interval (time between steps) in seconds
  setTimeout(_ => { 
    [...elems].forEach(elem => {
      elem.style.opacity = 1; 
      const timer = setInterval(_ => {
        if (elem.style.opacity <= 0) {
          clearInterval(timer);
          elem.style.display = `none`;
        }
        else {
          elem.style.opacity -= step;
        }
      }, interval * 1000);
    });
  }, delay * 1000);
}

function handleFileSelect(ev0) {
    // stop the default submit event happening;
    // we call submit() manually if validation passes
    ev0.preventDefault();
    const f = csv_file_chooser.files[0];
    const rdr = new FileReader();
    rdr.readAsText(f);
    // test when file has been read, get the contents, and pass them to the validator
    rdr.onloadend = ev1 => {
        if (ev1.target.readyState == FileReader.DONE) {
            if (ev0.target === csv_submit_btn) {
                const data = rdr.result;
                const cv = new CsvValidator(data);
                const errs = cv.validateFile();
                if (!errs || !errs.length) {  // if no errors, submit form (with file) to server
                    csv_import_form.submit();
                }
                else {
                    error_list.innerHTML = ``;
                    // Show user errors in modal; 
                    // user can dismiss modal and remains on results page; no HTTP post request is sent;
                    // or user can edit the file and retry;
                    errs.forEach( err => {
                        const li = document.createElement(`LI`);
                        const entry = document.createTextNode(err);
                        li.appendChild(entry);
                        error_list.appendChild(li);
                    });
                }
            }
        }
    };
}

// Function to populate Edit User modal and set action
function setUserToEdit(elem) {
    const user = elem.dataset;
    user.password = ``;
    [`name`, `email`, 'status', `password`].forEach(field => {
        document.getElementById(`edit-${field}`).value = user[field];
    });
    document.getElementById(`edit-admin`).checked = ~~user.admin;
    user_edit_form.action += `/${user.id}`;
} 

