<div class="mc_muzikc bg-theme">
    <audio></audio>
    <div class="mc_muzikc-ui">
        <div class="waves-effect waves-circle mc_muzikc-list-open"><i class="material-icons">queue_music</i></div>
        <div class="waves-effect waves-circle mc_muzikc-open"><i class="material-icons">keyboard_arrow_up</i></div>
        <div class="mc_muzikc-sb">
            <div class="mc_muzikc-dt"></div>
            <div class="mc_muzikc-vb"></div>
            <div class="mc_muzikc-pb">
                <div class="mc_muzikc-pb-wrapper">
                    <div class="mc_muzikc-pb-played">
                        <span class="mc_muzikc-pb-pointer"></span>
                    </div>
                </div>
            </div>
            <div class="mc_muzikc-t">
                <span class="mc_muzikc-t-elapsed">00:00</span>
                <div class="mc_muzikc-cts">
                    <ul>
                        <li><div class="mc_muzikc-ct mc_muzikc-ct-prev waves-effect waves-circle" data-action="prev"><i class="material-icons">fast_rewind</i></div></li>
                        <li><div class="mc_muzikc-ct mc_muzikc-ct-play waves-effect waves-circle" data-action="play"><i class="material-icons">play_arrow</i></div></li>
                        <li><div class="mc_muzikc-ct mc_muzikc-ct-next waves-effect waves-circle" data-action="next"><i class="material-icons">fast_forward</i></div></li>
                    </ul>
                </div>
                <span class="mc_muzikc-t-total">00:00</span>
            </div>
        </div>
    </div>
    <div class="mc_muzikc-pl"></div>
</div>
<script>
    mc_hazir(function () {
        mc_loadCss("<?= mc_plugins ?>muzik-calar/audio.css?v=8");
        mc_loadJs("<?= mc_plugins ?>muzik-calar/audio.js?v=8").done(function () {
            var t = {playlist: [<?= $mc_muzikcalar_list ?>]};
            $(".mc_muzikc").mc_muzikc(t);
        });
    });
</script>