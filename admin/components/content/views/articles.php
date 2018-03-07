<div class="white-card">
    <h2>Article Manager</h2>
    <div class="component-action-bar">
        <a href="index.php?component=settings&controller=settings&extension=content"><i class="fa fa-cog"></i> Settings</a><a href="index.php?component=content&controller=article"><i class="fa fa-plus"></i> New Article</a><a class="delete-by-ids"><i class="fa fa-trash"></i> Delete</a>
    </div>
    <form action="index.php?component=content&controller=articles&task=delete" method="post" class="admin-form">
        <table>
            <tr>
                <th class="frame-1">&nbsp;</th>
                <th class="frame-1"><strong>ID</strong></th>
                <th class="frame-3"><strong>Title</strong></th>
                <th class="frame-2"><strong>Category</strong></th>
                <th class="frame-1" style="text-align: center;"><strong>Published</strong></th>
                <th class="frame-2"><strong>Publish Date</strong></th>
                <th class="frame-1"><strong>Author</strong></th>
                <th class="frame-1"><strong>Hits</strong></th>
            </tr>
            <?php foreach ($this->model->articles as $article) { ?>
                <tr>
                    <td class="frame-1" style="text-align: center;"><input type="checkbox" name="ids[]" value="<?php echo $article->id; ?>" /></td>
                    <td class="frame-1"><?php echo $article->id; ?></td>
                    <td class="frame-3"><a href="index.php?component=content&controller=article&id=<?php echo $article->id; ?>"><?php echo $article->title; ?></a></td>
                    <td class="frame-2"><?php echo $article->category->title; ?></td>
                    <td class="frame-1" style="text-align: center;">
                        <a href="index.php?component=content&controller=article&task=<?php echo ($article->published == 1 ? "unpublish" : "publish"); ?>&id=<?php echo $article->id; ?>" class="btn btn-<?php echo ($article->published == 1 ? "success" : "danger"); ?>">
                            <i class="fa fa-<?php echo ($article->published == 1 ? "check" : "times"); ?>"></i>
                        </a>
                    </td>
                    <td class="frame-2"><?php echo date("jS M Y", $article->publish_time); ?></td>
                    <td class="frame-1">
                        <?php echo $article->author->real_name; ?>
                    </td>
                    <td class="frame-1">
                        <?php echo $article->hits; ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </form>
</div>