<div class="white-card">
    <h2>Extension Manager</h2>
    <div class="component-action-bar">
        <a href="index.php?component=settings&controller=settings&extension=extensions"><i class="fa fa-cog"></i> Settings</a>
    </div>
    <table>
        <tr>
            <th><strong>ID</strong></th>
            <th><strong>Title</strong></th>
            <th style="text-align: center;"><strong>Frontend?</strong></th>
            <th style="text-align: center;"><strong>Backend?</strong></th>
            <th style="text-align: center;"><strong>Enabled?</strong></th>
            <th><strong>Author</strong></th>
            <th><strong>Version</strong></th>
        </tr>
        <?php foreach ($this->model->extensions as $extension) { ?>
            <tr>
                <td><?php echo $extension->id; ?></td>
                <td><a href="index.php?component=extensions&controller=extension&id=<?php echo $extension->id; ?>"><?php echo $extension->title; ?></a></td>
                <td style="text-align: center;"><i class="fa fa-<?php echo ($extension->is_frontend == 1 ? "check" : "times"); ?>"></i></td>
                <td style="text-align: center;"><i class="fa fa-<?php echo ($extension->is_backend == 1 ? "check" : "times"); ?>"></i></td>
                <?php if ($extension->is_locked == 1) { ?>
                    <td style="text-align: center;"><button class="btn btn-disabled"><i class="fa fa-lock"></i></button></td>
                <?php } else { ?>
                    <td style="text-align: center;">
                        <a href="index.php?component=extensions&controller=extension&task=<?php echo ($extension->enabled == 1 ? "unpublish" : "publish"); ?>&id=<?php echo $extension->id; ?>" class="btn btn-<?php echo ($extension->enabled == 1 ? "success" : "danger"); ?>">
                            <i class="fa fa-<?php echo ($extension->enabled == 1 ? "check" : "times"); ?>"></i>
                        </a>
                    </td>
                <?php } ?>
                <td><a href="<?php echo $extension->author_url; ?>" target="_blank"><?php echo $extension->author_name; ?></a></td>
                <td><?php echo $extension->version; ?></td>
            </tr>
        <?php } ?>
    </table>
</div>