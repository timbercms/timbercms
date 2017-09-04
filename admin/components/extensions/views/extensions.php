<div class="card">
    <h2>Extension Manager</h2>
    <table>
        <tr>
            <th><strong>ID</strong></th>
            <th><strong>Title</strong></th>
            <th><strong>Frontend?</strong></th>
            <th><strong>Backend?</strong></th>
            <th><strong>Locked?</strong></th>
            <th><strong>Author</strong></th>
            <th><strong>Version</strong></th>
        </tr>
        <?php foreach ($this->model->extensions as $extension) { ?>
            <tr>
                <td><?php echo $extension->id; ?></td>
                <td><a href="index.php?component=extensions&controller=extension&id=<?php echo $extension->id; ?>"><?php echo $extension->title; ?></a></td>
                <td><i class="fa fa-<?php echo ($extension->is_frontend == 1 ? "check" : "times"); ?>"></i></td>
                <td><i class="fa fa-<?php echo ($extension->is_backend == 1 ? "check" : "times"); ?>"></i></td>
                <td><i class="fa fa-<?php echo ($extension->is_locked == 1 ? "check" : "times"); ?>"></i></td>
                <td><a href="<?php echo $extension->author_url; ?>" target="_blank"><?php echo $extension->author_name; ?></a></td>
                <td><?php echo $extension->version; ?></td>
            </tr>
        <?php } ?>
    </table>
</div>