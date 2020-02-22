<!DOCTYPE html>
<!-- Based on code from https://getbootstrap.com/docs/4.1/examples/dashboard/ -->

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Test Results Portal</title>
    <meta name="description" content="A Web Portal for viewing call test results">
    <meta name="author" content="John Lynch">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/f713aa5906.js" crossorigin="anonymous"></script>
    <!-- Custom styles for this template -->
    <?= $this->Html->css('style') ?>
  </head>
  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">RESULTS PORTAL</a>
      <?= $this->Flash->render() ?>
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <?= $this->Html->link($authUser['name'], [
                'controller' => 'Users',
                'action' => 'edit_self',
                $authUser['id']
              ], [
                'class' => 'nav-link',
                'id' => 'edit-profile',
                'data-toggle' => 'modal',
                'data-target' => '#user-ac-self-edit'
              ]) ?>
        </li>
      </ul>
    </nav>

<!-- START OF LEFT NAVIGATION -->

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky pt-5">
            <ul class="nav flex-column">
              <button class="nav-item">
                <?= $this->Html->link(__('Results'), ['controller' => 'Results', 'action' => 'index'], ['class' => 'nav-link text-nowrap']) ?>
              </button>
              <?php if ($authUser['admin']): ?>
              <button class="nav-item">
                <?= $this->Html->link(__('Users'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'nav-link text-nowrap']) ?>
              </button>
              <?php endif; ?>
              <button class="nav-item">
                <?= $this->Html->link(__('Logout'), ['controller' => 'Users', 'action' => 'logout'], ['class' => 'nav-link text-nowrap']) ?>
              </button>
            </ul>
          </div>
        </nav>
        
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <div class="container-fluid">
              <div class="row pt-3">
                <?= $this->fetch('topbar') ?>            
              </div>
              <div class="row pt-2">
                <?= $this->fetch('content') ?>        
              </div>
            </div>
        </main>
      </div>
    </div>
    <footer>
    </footer>

    <!-- JQuery and Bootstrap etc.
    ================================================== -->
    <script
      src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
      integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
      crossorigin="anonymous">
    </script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
      integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
      crossorigin="anonymous">
    </script>

    <?= $this->Html->script('main') ?>

    <!-- User account self-edit modal -->

        <div class="modal" id="user-ac-self-edit">
          <div class="modal-dialog">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <?= $this->element('useraccountselfeditform', ['user' => $authUser]) ?>
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

    <!-- END OF USER ACCOUNT EDIT MODAL -->



  </body>
</html>
