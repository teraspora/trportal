class CsvValidator {

    nthIndexOf = (s, t, n) => s.split(t, n).join(t).length;
    // contains_duplicates = arr => [...new Set(arr)].length < arr.length;

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

    msgs = {
        // Note:  line_no + 1 accounts for stripped header row
        wrong_length_row:   (line_no, field_count, expected_count) => `On line ${line_no + 1}: Found ${field_count} columns, expecting ${expected_count} columns`,
        empty_field:        (line_no, column_no) => `On line ${line_no + 1}, column ${column_no}: required field missing`,
        bad_format:         (line_no, column_no, field_value) => `On line ${line_no + 1}, column ${column_no}: Found ‘${field_value}’ which has an unexpected format.`,
        duplicate_id:       line_no => `On line ${line_no + 1}: Row already defined in file previously`,
    }

    ids = [];
    
    constructor(csv_file_data) {
        this.data = csv_file_data;
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
const upload_form = document.getElementById(`upload-form`);

document.onreadystatechange = _ => {
  if (document.readyState === 'complete') {
    csv_submit_btn.addEventListener('click', handleFileSelect, false);
    fade(msgs);
  }
};
// End top-level code


// FUNCTIONS:

function fade(elems, delay = 4, interval = 0.1, step = 0.1) {
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
    // test when read
    rdr.onloadend = ev1 => {
        if (ev1.target.readyState == FileReader.DONE) {
            if (ev0.target === csv_submit_btn) {
                const data = rdr.result;
                console.log(`*** Got CSV data\n\n`);
                const cv = new CsvValidator(data);
                const errs = cv.validateFile();
                if (!errs || !errs.length) {
                    console.log(`No errors, submitting file...`);
                    csv_import_form.submit();
                }
                else {
                    // upload_form.style.display = 'none';
                    error_list.innerHTML = ``;
                    errs.forEach( err => {
                        console.log(`Error: ${err}`);
                        const li = document.createElement(`LI`);
                        const entry = document.createTextNode(err);
                        li.appendChild(entry);
                        error_list.appendChild(li);
                    });
                    // Show user errors in modal; 
                    // user can dismiss modal and remains on results page; no HTTP post request is sent;
                }
            }
        }
    };
}
