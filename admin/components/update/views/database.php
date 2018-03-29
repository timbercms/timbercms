<div class="white-card">
    <h1 style="margin-bottom: 20px;">Update the database</h1>
    <?php if (file_exists(__DIR__ ."/../../../../databaseUpdate.txt")) { ?>
        <a href="index.php?component=update&controller=database&task=update" class="btn btn-primary">Click to Update</a>
    <?php } else { ?>
        No database update required!
    <?php } ?>
</div>