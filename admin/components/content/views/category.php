<div class="white-card">
    <h2>Category Manager</h2>
    <div class="component-action-bar">
        <a href="index.php?component=content&controller=categories" class="button"><i class="fa fa-chevron-left"></i> Back to List</a>
    </div>
    <form action="index.php?component=content&controller=category&task=save" method="post">
        <?php $this->model->form->display(); ?>
    </form>
</div>