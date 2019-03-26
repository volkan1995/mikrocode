<div id="selector">
    <div id="selector-top"></div>
    <div id="selector-left"></div>
    <div id="selector-right"></div>
    <div id="selector-bottom"></div>
</div>
<style>
    #selector-top, #selector-bottom {
        border-top: 1px dashed #337ab7;
        border-bottom: 1px dashed #337ab7;
        height:2px;
        position: fixed;
        transition:all 250ms ease;
        z-index: 999999;
    }
    #selector-left, #selector-right {
        border-right: 1px dashed #337ab7;
        border-left: 1px dashed #337ab7;
        width:2px;
        position: fixed;
        transition:all 250ms ease;
        z-index: 999999;
    }
    .n{
        -webkit-transform: scale(3) translateX(100px)   
    }
</style>
<script>
    mc_hazir(function () {
        var elements = {
            top: $('#selector-top'),
            left: $('#selector-left'),
            right: $('#selector-right'),
            bottom: $('#selector-bottom')
        };

        $(document).mousemove(function (event) {
            if (event.target.id.indexOf('selector') !== -1 || event.target.tagName === 'BODY' || event.target.tagName === 'HTML')
                return;

            var $target = $(event.target);
            targetOffset = $target[0].getBoundingClientRect(),
                    targetHeight = targetOffset.height,
                    targetWidth = targetOffset.width;
           /* console.log(targetOffset); */
            elements.top.css({
                left: (targetOffset.left - 3),
                top: (targetOffset.top - 3),
                width: (targetWidth + 6)
            });
            elements.bottom.css({
                top: (targetOffset.top + targetHeight + 1),
                left: (targetOffset.left - 3),
                width: (targetWidth + 6)
            });
            elements.left.css({
                left: (targetOffset.left - 3),
                top: (targetOffset.top - 2),
                height: (targetHeight + 4)
            });
            elements.right.css({
                left: (targetOffset.left + targetWidth + 1),
                top: (targetOffset.top - 2),
                height: (targetHeight + 4)
            });

        });
    });
</script>
<?php
$mc_endTime = explode(" ", microtime());
$mc_endTime = doubleval($mc_endTime[1]) + doubleval($mc_endTime[0]);
$mc_resultTime = round(abs($mc_endTime - $m_iz) * 1000);