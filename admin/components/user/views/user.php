<div class="white-card">
    <h2>User Manager</h2>
    <div class="component-action-bar">
        <a href="index.php?component=user&controller=users" class="button"><i class="fa fa-chevron-left"></i> Back to List</a>
    </div>
    <form action="index.php?component=user&controller=user&task=save" method="post">
        <?php $this->model->form->display(); ?>
    </form>
</div>