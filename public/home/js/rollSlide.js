/**
 * Created by f on 2015/5/8.
 */
(function($){
    $.fn.rollSlide = function(obj){
        var $self = this,
            orientation = obj.orientation || 'left',   //婊氬姩鏂瑰紡
            num = obj.num || 1,      //婊氬姩鏁伴噺
            v = (typeof obj.v === 'number') ? obj.v : 0,    //婊氬姩閫熷害
            minTime = (typeof obj.space === 'number') ? ((obj.space >= 100) ? obj.space : 100) : 100,    //鏈€灏忛棿闅斾负 100 ms 锛�
            space = minTime + v || 5000 + v,    //婊氬姩闂撮殧  榛樿 5000ms
            isRoll = obj.isRoll,   //鑷姩鎾斁
            isStart = true,
            roll = function(ori, n, v){
                var $ul = $self.find('.roll__list'),
                    $item = $ul.find('li'),
                    range = 0,
                    i,len = $item.length,
                    sliceItem = [],
                    cloneSliceItem = [],
                    startTime = (new Date()).getTime(),
                    //瀛樻斁婊氬姩杩囩殑 item
                    memory = function(){
                        var arr = [];

                        if(ori === 'left' || ori === 'top'){
                            for(i = 0; i < n; i++){
                                range += ori === 'left' ? $($item[i]).outerWidth(true) : $($item[i]).outerHeight(true); // left 鍙� width锛宼op 鍙� height
                                arr.push($item[i]);
                            }
                        } else if(ori === 'right' || ori === 'bottom'){
                            for(i = len - n; n > 0; n--, i++){
                                range += ori === 'right' ? $($item[i]).outerWidth(true) : $($item[i]).outerHeight(true);
                                arr.push($item[i]);
                            }
                        }
                        return arr;
                    };

                isStart = false;         //鍏抽棴婊氬姩
                sliceItem = memory();
                cloneSliceItem = $(sliceItem).clone();
                //鍒ゆ柇寰€鍝釜鏂瑰悜绉诲姩
                switch (ori){
                    case 'left':
                        $ul.append(cloneSliceItem);
                        $ul.animate({
                            'left': -range + 'px'
                        },v,function(){
                            $(this).css({'left': 0});
                            $(sliceItem).remove();
                            isStart = true;    //寮€鍚粴鍔�
                        });
                        break;
                    case 'right':
                        $ul.prepend(cloneSliceItem);
                        $ul.css('left', -range + 'px');
                        $ul.animate({
                            'left': 0
                        },v,function(){
                            $(sliceItem).remove();
                            isStart = true;    //寮€鍚粴鍔�
                        });
                        break;
                    case 'top':
                        $ul.append(cloneSliceItem);
                        $ul.animate({
                            'top': -range + 'px'
                        },v,function(){
                            $(this).css({'top': 0});
                            $(sliceItem).remove();
                            isStart = true;    //寮€鍚粴鍔�
                        });
                        break;
                    case 'bottom':
                        $ul.prepend(cloneSliceItem);
                        $ul.css('top', -range + 'px');
                        $ul.animate({
                            'top': 0
                        },v, function(){
                            $(sliceItem).remove();
                            isStart = true;    //寮€鍚粴鍔�
                        });
                        break;
                }
            },
            init = function(){
                var $ul = $self.find('.roll__list'),
                    $item = $ul.find('li'),
                    len = $item.length,
                    timer;

                num = num <= len ? num : len;   //婊氬姩涓暟瓒呰繃鍒楄〃鏁帮紝鍙栧垪琛ㄦ暟
                if(len > 1){
                    $self.on('click', '.pre', function(){
                        if(isStart){
                            //妯悜婊氬姩
                            if(orientation === 'left' || orientation === 'right'){
                                roll('right', num, v);
                            } else{           //绾靛悜婊氬姩
                                roll('bottom', num, v);
                            }
                        }
                    }).
                    on('click', '.next', function(){
                        if(isStart){
                            //妯悜婊氬姩
                            if(orientation === 'left' || orientation === 'right'){
                                roll('left', num, v);
                            } else{           //绾靛悜婊氬姩
                                roll('top', num, v);
                            }
                        }
                    }).
                    hover(function(){
                        clearInterval(timer);
                    }, function(){
                        if(isRoll){
                            timer = setInterval(function(){
                                roll(orientation, num, v);
                            },space);
                        }
                    }).
                    trigger('mouseout');
                }
            };

        init();
    };
    $.fn.rollNoInterval = function(){
        var $self = this,
            $ul = $self.find('.roll__list'),
            $item = $ul.find('li'),
            len = $item.length,
            timer,
            left = function(){
                var offset, i,
                    range,
                    $sliceItem;

                $sliceItem = $($item[0]);
                range = $sliceItem.outerWidth(true);
                timer = setInterval(function(){
                    offset = $ul.css('left');
                    offset = parseInt(offset);
                    if(offset > -range){
                        i = offset - 1;
                        $ul.css('left', i + 'px');
                        offset = $ul.css('left');
                    } else{
                        $sliceItem.detach();
                        $ul.css('left', 0);
                        $ul.append($sliceItem);
                        $sliceItem = $($ul.find('li')[0]);
                        range = $sliceItem.outerWidth(true);
                    }
                }, 50);
            },
            right = function(){
                var offset, i,
                    range,
                    $sliceItem;

                $sliceItem = $($item[len - 1]);
                range = $sliceItem.outerWidth(true);
                timer = setInterval(function(){
                    offset = $ul.css('right');
                    offset = parseInt(offset);
                    if(offset > -range){
                        i = offset - 1;
                        $ul.css('right', i + 'px');
                        offset = $ul.css('right');
                    } else{
                        $sliceItem.detach();
                        $ul.css('right', 0);
                        $ul.prepend($sliceItem);
                        $sliceItem = $($ul.find('li')[len - 1]);
                        range = $sliceItem.outerWidth(true);
                    }
                }, 50);
            },
            top = function(){
                var offset, i,
                    range,
                    $sliceItem;

                $sliceItem = $($item[0]);
                range = $sliceItem.outerHeight(true);
                timer = setInterval(function(){
                    offset = $ul.css('top');
                    offset = parseInt(offset);
                    if(offset > -range){
                        i = offset - 1;
                        $ul.css('top', i + 'px');
                        offset = $ul.css('top');
                    } else{
                        $sliceItem.detach();
                        $ul.css('top', 0);
                        $ul.append($sliceItem);
                        $sliceItem = $($ul.find('li')[0]);
                        range = $sliceItem.outerHeight(true);
                    }
                }, 50);
            },
            bottom = function(){
                var offset, i,
                    range,
                    $sliceItem;

                $sliceItem = $($item[len - 1]);
                range = $sliceItem.outerHeight(true);
                timer = setInterval(function(){
                    offset = $ul.css('bottom');
                    offset = parseInt(offset);
                    if(offset > -range){
                        i = offset - 1;
                        $ul.css('bottom', i + 'px');
                        offset = $ul.css('bottom');
                    } else{
                        $sliceItem.detach();
                        $ul.css('bottom', 0);
                        $ul.prepend($sliceItem);
                        $sliceItem = $($ul.find('li')[len - 1]);
                        range = $sliceItem.outerHeight(true);
                    }
                }, 50);
            },
            init = function(){
                $self.hover(function(){
                    clearInterval(timer);
                }, function(){

                });
            };

        //init();
        return {
            left: left,
            right: right,
            top: top,
            bottom: bottom
        }
    }
})(jQuery);