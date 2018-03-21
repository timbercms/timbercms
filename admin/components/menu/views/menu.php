<div class="white-card">
    <h2>Menu Manager</h2>
    <div class="component-action-bar">
        <a href="index.php?component=menu&controller=menus" class="button"><i class="fa fa-chevron-left"></i> Back to List</a>
    </div>
    <form action="index.php?component=menu&controller=menu&task=save" method="post">
        <?php $this->model->form->display(); ?>
    </form>
</div>