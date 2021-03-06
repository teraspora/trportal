<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>


<?php
$this->start('topbar');
    // User filter
    echo $this->Element('userfilterdropdown'); 
    // User search form
    echo $this->Element('usersearchform'); 
    // Add user link    
    echo $this->Html->link(__('Add User'), ['action' => 'add'],
         ['class' => 'btn btn-info btn-sm',
          'data-toggle' => 'modal',
          'data-target' => '#user-ac-add']);
$this->end();
?>

<div class="results index large-9 medium-8 columns content">
    <table class="table table-striped" cellpadding="4" cellspacing="8">
        <thead class="thead-dark">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_on') ?></th>
                <th scope="col"><?= $this->Paginator->sort('admin') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $this->Number->format($user->id) ?></td>
                <td><?= h($user->name) ?></td>
                <td><?= h($user->email) ?></td>
                <td><?= h($user->creator->name) ?></td>
                <td><?= h($user->created_on->format('Y-m-d H:i:s')) ?></td>
                <td><?= h($user->admin) ?></td>
                <td><?= h($user->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id], 
                        ['onclick' => 'setUserToEdit(this)',
                         'data-toggle' => 'modal',
                         'data-target' => '#user-ac-edit',
                         'data-id' => $user->id,
                         'data-name' => $user->name,
                         'data-email' => $user->email,
                         'data-admin' => $user->admin,
                         'data-status' => $user->status]) ?>
                    <?= ' | ' ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete record?')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>

<!-- User account edit modal -->

    <div class="modal" id="user-ac-edit">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <?= $this->element('useraccounteditform') ?>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

<!-- END OF USER ACCOUNT EDIT MODAL -->

<!-- User account add modal -->

    <div class="modal" id="user-ac-add">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <?= $this->element('useraccountaddform') ?>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

<!-- END OF USER ACCOUNT ADD MODAL -->
