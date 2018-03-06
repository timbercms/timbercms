<div class="white-card">
    <h2>Article Manager</h2>
    <div class="component-action-bar">
        <a href="index.php?component=content&controller=articles"><i class="fa fa-chevron-left"></i> Back to List</a>
    </div>
    <form action="index.php?component=content&controller=article&task=save" method="post">
        <?php $this->model->form->display(); ?>
    </form>
</div>