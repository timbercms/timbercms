<?php $version = simplexml_load_file(__DIR__ ."/../../../version.xml"); ?>
<div class="white-card">
    <h2>About Bulletin CMS.</h2>
    <p>Bulletin CMS uses a few external packages, and segments of code to make everything possible. Big thanks to the maintainers of these packages!</p>
    <h3 style="margin-top: 40px;">Installed Version</h3>
    <p>v<?php echo $version->numerical; ?></p>
    <h3 style="margin-top: 40px;">External Packages</h3>
    <ul>
        <li><p><strong>TinyMCE</strong></p><p>WYSIWYG Editor</p><p><a href="https://www.tinymce.com/" target="_blank">https://www.tinymce.com/</a></p><p>&nbsp;</p></li>
        <li><p><strong>Responsive File Manager</strong></p><p>File Manager</p><p><a href="http://www.responsivefilemanager.com/" target="_blank">http://www.responsivefilemanager.com/</a></p><p>&nbsp;</p></li>
        <li><p><strong>Relative Time by Zachstronaut</strong></p><p>Allows for use of "X Seconds Ago" time formats.</p><p><a href="https://gist.github.com/zachstronaut/1184831" target="_blank">https://gist.github.com/zachstronaut/1184831</a></p><p>&nbsp;</p></li>
    </ul>
</div>