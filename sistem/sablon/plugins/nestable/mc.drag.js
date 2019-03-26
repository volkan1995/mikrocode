(function($){
    var methods = {
        init: function(options) {
            var list = $(this), cells = [];
            var settings = $.extend({
                trigger: 3,
                selector: 'li',
                moveClass: '.mc_move_icon',
                dragClass: '_surukleniyor',
                placeholder: '<li class="mc_surukleb_placeholder mcd_placeholder"></li>'
            }, options);

            function calculatePositions(){
                list.children(settings.selector).each(function(key, item){
                    var offset = $(item).offset();

                    cells[key] = {
                            x1: offset.left,
                            y1: offset.top,
                            x2: offset.left + $(item).outerWidth(),
                            y2: offset.top + $(item).outerHeight(),
                    };

                    $(item).css({
                            left: cells[key].x1 - list.offset().left,
                            top: cells[key].y1 - list.offset().top
                    });
                });
            }

            function findPosition(x, y) {
                var newPositon = null;
                $.each(cells, function(key, item) {
                    if (x > item.x1 && x < item.x2 && y > item.y1 && y < item.y2){
                        newPositon = key;
                        return;
                    }
                });
                return newPositon;
            }

            function insertItem(item, exclude, position) {
                if (position == 0) {
                    item.prependTo(list);
                }else{
                    item.insertAfter(list.children(settings.selector).not(item).not(exclude)[position - 1]);
                }
            }
            $(settings.moveClass).css({'cursor':"move"});
            var mc_sb_devam = false;
            list.on('mousedown', settings.moveClass, function(e2){
                mc_sb_devam = true;
            });
            list.on('mousedown', settings.selector, function(e1){
                if(mc_sb_devam){
                    calculatePositions();
                    e1.preventDefault();
                    var draggedItem =  $(this),
                            placeholder = $(settings.placeholder),
                            dragtf = false;
                    
                    var genislik = draggedItem[0].getBoundingClientRect().width;
                    placeholder.css({'width':genislik, 'height':draggedItem.height(), 'margin':draggedItem.css('margin')});

                    var offset = {
                            top: e1.pageY - draggedItem.offset().top + list.offset().top,
                            left: e1.pageX - draggedItem.offset().left + list.offset().left
                    };                              

                    var prevPosition = position = draggedItem.index();

                    if(dragtf){ placeholder.insertBefore(draggedItem); }

                    $(document).on('mousemove', function(e){
                        if((e1.pageY > (e.pageY + settings.trigger) || e1.pageY < (e.pageY - settings.trigger)) || e1.pageX > (e.pageX + settings.trigger) || e1.pageX < (e.pageX - settings.trigger)){
                            draggedItem =  draggedItem.addClass(settings.dragClass);
                            if(!dragtf) {placeholder.insertBefore(draggedItem); }
                            dragtf = true;
                            e.preventDefault();
                            draggedItem.css({
                                    top: e.pageY - offset.top,
                                    left: e.pageX - offset.left
                            });
                            var newPosition = findPosition(e.pageX, e.pageY);
                            if (newPosition != position && newPosition != null) {
                                position = newPosition;
                                insertItem(placeholder, draggedItem, position);
                                if (typeof(settings.onChangePosition) == 'function'){ settings.onChangePosition(position, prevPosition, draggedItem);}
                            }
                        }
                    }).on('mouseup', function(e){
                        mc_sb_devam = false;
                        if(!dragtf){
                            placeholder.remove();
                            $(this).off('mousemove').off('mouseup');
                            return true;                                        
                        }
                        placeholder.insertBefore(draggedItem);
                        insertItem(draggedItem, placeholder, position);
                        placeholder.remove();
                        draggedItem.removeClass(settings.dragClass);
                        $(this).off('mousemove').off('mouseup');
                        if (typeof(settings.onStop) == 'function')
                        {settings.onStop(position, prevPosition, draggedItem);}
                        dragtf = false;
                    });
                    mc_sb_devam = false;
                }
            });
        }
    };
    $.fn.suruklebirak = function(method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        }else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        }else{
            $.error('Method '+method+' does not exist on jQuery.suruklebirak');
        }
    };
})(jQuery);