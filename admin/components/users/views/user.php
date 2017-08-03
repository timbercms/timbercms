<div class="card">
    <h2>User Manager</h2>
    <div class="action-bar">
        <a href="index.php?component=users&controller=users"><i class="fa fa-chevron-left"></i> Back to List</a>
    </div>
    <form action="index.php?component=users&controller=user&task=save" method="post">
        <?php $this->model->form->display(); ?>
    </form>
</div>