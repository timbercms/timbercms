<div class="white-card">
    <h2>Category Manager</h2>
    <form action="index.php?component=content&controller=category&task=save" method="post" class="admin-form">
        <div class="component-action-bar">
            <a href="index.php?component=content&controller=categories" class="button" style="float: left;"><i class="fa fa-chevron-left"></i> Back to List</a>
            <button type="submit" class="button green-button"><i class="fas fa-save"></i> Save</button>
            <button type="submit" class="button green-button save-and-new" data-action="index.php?component=content&controller=category&task=saveandnew"><i class="fas fa-save"></i> Save & New</button>
        </div>
        <?php $this->model->form->display(); ?>
    </form>
</div>