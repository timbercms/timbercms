<div class="search-module">
    <form action="<?php echo Core::route("index.php?component=content&controller=search"); ?>" method="get">
        <div class="form-group">
            <input type="text" class="form-control" name="query" placeholder="Enter keywords to search" />
        </div>
        <p style="text-align: right;"><button type="submit" class="button">Search</button></p>
    </form>
</div>