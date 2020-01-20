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
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <?= $this->Html->link($authUser['name'], ['controller' => 'Users', 'action' => 'edit_self', $authUser['id']], ['class' => 'nav-link']) ?>
        </li>
      </ul>
    </nav>

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

        <?= $this->Flash->render() ?>   
        
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

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script
      src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
      integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
      crossorigin="anonymous">
    </script>
   <!--  <script
      src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
      integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
      crossorigin="anonymous"></script> -->
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
      integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
      crossorigin="anonymous">
    </script>

  </body>
</html>
