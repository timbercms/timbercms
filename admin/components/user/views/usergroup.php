<div class="white-card">
    <h2>Usergroups Manager</h2>
    <div class="component-action-bar">
        <a href="index.php?component=user&controller=usergroups"><i class="fa fa-chevron-left"></i> Back to List</a>
    </div>
    <form action="index.php?component=user&controller=usergroup&task=save" method="post">
        <?php $this->model->form->display(); ?>
    </form>
</div>