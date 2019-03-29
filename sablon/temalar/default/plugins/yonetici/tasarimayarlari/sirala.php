<form class="row clearfix" id="content-form">
    <div class="col-md-9 col-sm-8 col-xs-12">
        <div class="card">
            <div class="body dd nestable-with-handle">
                <ol class="dd-list">
                    <?php foreach ($inc_sort as $inc): ?>
                        <li class="dd-item dd3-item" data-id="<?= $inc ?>">
                            <div class="dd-handle">
                                <i class="material-icons">drag_handle</i>
                            </div>
                            <div class="dd3-content"><?= mc_dil($inc) ?></div>
                        </li>       
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-4 col-xs-12">
        <div class="card">
            <div class="header"><?= mc_ustmenu($mc_modul_ayar['menu'], $mc_headtitle) ?></div>
            <div class="body">
                <button type="submit" class="btn btn-sm btn-theme waves-effect"><?= mc_dil('kaydet') ?></button>
                <input type="hidden" class="ddtextarea" name="sira"/>             
            </div>
        </div>
    </div>
</form>
<script>
    mc_loadJs("<?= mc_plugins ?>nestable/jquery.nestable.js").done(function () {
        $('.dd').nestable({maxDepth: 1});
        $('.dd').on('change', function () {
            $('.ddtextarea').val(window.JSON.stringify($(this).nestable('serialize')));
        });
    });
</script>
