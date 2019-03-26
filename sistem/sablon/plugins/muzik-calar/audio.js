var mc_muzikc_kontrol;
(function($){
    var mc_muzikc_plugname = "mc_muzikc",
    defaults = {
        playlist: [],
        defaultAlbum: undefined,
        defaultArtist: undefined,
        defaultTrack: 0,
        autoPlay: false,
        debug: false
    };
    function mc_muzikc_plugin( $context, options ){
        this.settings         = $.extend( true, defaults, options );
        this.$context         = $context;
        this.domAudio         = this.$context.find("audio")[0];
        this.$domPlaylist     = this.$context.find(".mc_muzikc-pl");
        this.$domControls     = this.$context.find(".mc_muzikc-cts");
        this.$domVolumeBar    = this.$context.find(".mc_muzikc-volume");
        this.$domDetails      = this.$context.find(".mc_muzikc-dt");
        this.$domStatusBar    = this.$context.find(".mc_muzikc-sb");
        this.$domProgressBar  = this.$context.find(".mc_muzikc-pb-wrapper");
        this.$domTime         = this.$context.find(".mc_muzikc-t");
        this.$domElapsedTime  = this.$context.find(".mc_muzikc-t-elapsed");
        this.$domTotalTime    = this.$context.find(".mc_muzikc-t-total");
        this.currentState       = "pause";
        this.currentTrack       = this.settings.defaultTrack;
        this.currentElapsedTime = undefined;
        this.timer              = undefined;
        this.init();
    }
    mc_muzikc_plugin.prototype = {
        init: function(){
            var self = this;
            mc_muzikc_kontrol = self;
            self.renderPlaylist();
            self.preLoadTrack();
            self.highlightTrack();
            self.updateTotalTime();
            self.events();
            self.debug();
            mc_muzikc_kontrol.domAudio.volume = 1;
        },
        play: function($btn){
            var self = this;
            self.domAudio.play();
            if(self.currentState === "play"){return;}
            clearInterval(self.timer);
            self.timer = setInterval( self.run.bind(self), 50 );
            self.currentState = "play";
            $btn.data("action", "pause");
            $btn.html("<i class='material-icons'>pause</i>");
            $btn.toggleClass('active');
        },
        pause: function($btn){
            var self = this;
            self.domAudio.pause();
            clearInterval(self.timer);
            self.currentState = "pause";
            $btn.data("action", "play");
            $btn.html("<i class='material-icons'>play_arrow</i>");
            $btn.toggleClass('active');
        },
        stop: function($btn){
            var self = this;
            self.domAudio.pause();
            self.domAudio.currentTime = 0;
            self.animateProgressBarPosition();
            clearInterval(self.timer);
            self.updateElapsedTime();
            self.currentState = "stop";
        },
        prev: function($btn){
            var self  = this,track;
            (self.currentTrack === 0)
              ? track = self.settings.playlist.length - 1
              : track = self.currentTrack - 1;
            self.changeTrack(track);
        },
        next: function($btn){
            var self = this,track;
            (self.currentTrack === self.settings.playlist.length - 1)
              ? track = 0
              : track = self.currentTrack + 1;
            self.changeTrack(track);
        },
        preLoadTrack: function(){
            var self      = this,
                defTrack  = self.settings.defaultTrack;
            self.changeTrack( defTrack );
            self.stop();
        },
        changeTrack: function(index){
            var self = this;
            self.currentTrack  = index;
            self.domAudio.src  = self.settings.playlist[index].file;
            if(self.currentState === "play" || self.settings.autoPlay){self.play();}
            self.highlightTrack();
            self.renderDetails();
        },
        events: function(){
            var self = this;
            self.$domControls.on("click", ".mc_muzikc-ct", function(){
                var $btn    = $(this),
                    action  = $btn.data("action");
                switch( action ){
                    case "prev": self.prev.call(self, $btn); break;
                    case "next": self.next.call(self, $btn); break;
                    case "pause": self.pause.call(self, $btn); break;
                    case "stop": self.stop.call(self, $btn); break;
                    case "play": self.play.call(self, $btn); break;
                };
            });
            self.$domPlaylist.on("click", ".mc_muzikc-pl-i", function(e){
                var item = $(this),
                    track = item.data("track"),
                    index = item.index();
                if(self.currentTrack === index){return;}
                self.changeTrack(index);
            });
            self.$domProgressBar.on("click", function(e){
                self.updateProgressBar(e);
                self.updateElapsedTime();
            });
            $(self.domAudio).on("loadedmetadata", function(){
                self.animateProgressBarPosition.call(self);
                self.updateElapsedTime.call(self);
                self.updateTotalTime.call(self);
            });
        },
        getAudioSeconds: function(string){
            var self    = this,
                string  = string % 60;
                string  = self.addZero( Math.floor(string), 2 );
            (string < 60) ? string = string : string = "00";
            return string;
        },
        getAudioMinutes: function(string){
            var self    = this,
                string  = string / 60;
                string  = self.addZero( Math.floor(string), 2 );
            (string < 60) ? string = string : string = "00";
            return string;
        },

        addZero: function(word, howManyZero){
            var word = String(word);
            while(word.length < howManyZero) word = "0" + word;
            return word;
        },
        removeZero: function(word, howManyZero){
            var word  = String(word),
                i     = 0;
            while(i < howManyZero){
              if(word[0] === "0") { word = word.substr(1, word.length); } else { break; }
              i++;
            }
            return word;
        },
        highlightTrack: function(){
            var self      = this,
                tracks    = self.$domPlaylist.children(),
                className = "active";
            tracks.removeClass(className);
            tracks.eq(self.currentTrack).addClass(className);
        },
        renderDetails: function(){
            var self          = this,
                track         = self.settings.playlist[self.currentTrack],
                file          = track.file,
                trackName     = track.trackName,
                template      =  "";
                template += "<p>";
                template += "<span>" + trackName + "</span>";
                template += "</p>";
            self.$domDetails.html(template);
        },
        renderPlaylist: function(){
            var self = this, template = "";
            $.each(self.settings.playlist, function(i, a){
                var file          = a["file"],
                    trackName     = a["trackName"];
                template += "<div class='mc_muzikc-pl-i waves-effect' data-track='" + file + "'>";
                template += "<div class='dosya_simge'><i class='material-icons'>music_note</i></div>";
                template += "<p class='mc_muzikc-pl-meta-n' title='" + trackName + "'>" + trackName + "</p>";
                template += "</div>";
            });
            self.$domPlaylist.html(template);
        },
        run: function(){
            var self = this;
            self.animateProgressBarPosition();
            self.updateElapsedTime();
            if(self.domAudio.ended) self.next();
        },
        animateProgressBarPosition: function(){
            var self        = this,
                percentage  = (self.domAudio.currentTime * 100 / self.domAudio.duration) + "%",
                styles      = { "width": percentage };
            self.$domProgressBar.children().eq(0).css(styles);
        },
        updateProgressBar: function(e){
            var self = this,
                mouseX,
                percentage,
                newTime;
            if(e.offsetX){ mouseX = e.offsetX; }
            if(mouseX === undefined && e.layerX){ mouseX = e.layerX; }
            percentage = mouseX / self.$domProgressBar.width();
            newTime = self.domAudio.duration * percentage;
            self.domAudio.currentTime = newTime;
            self.animateProgressBarPosition();
        },
        updateElapsedTime: function(){
            var self      = this,
                time      = self.domAudio.currentTime,
                minutes   = self.getAudioMinutes(time),
                seconds   = self.getAudioSeconds(time),
                audioTime = minutes + ":" + seconds;
            self.$domElapsedTime.text( audioTime );
        },
        updateTotalTime: function(){
            var self      = this,
                time      = self.domAudio.duration,
                minutes   = self.getAudioMinutes(time),
                seconds   = self.getAudioSeconds(time),
                audioTime = minutes + ":" + seconds;
            self.$domTotalTime.text( audioTime );
        },
        debug: function() {
            var self = this;
            if(self.settings.debug) console.log(self.settings);
        }
    };
    $.fn[mc_muzikc_plugname] = function( options ) {
      var instantiate = function(){
          return new mc_muzikc_plugin( $(this), options );
      };
      $(this).each(instantiate);
    };
    var mc_muzikc_open = false;
    var mc_muzikc_list_open = false;
    $(document).on('click', '.mc_muzikc-open', function(e){
        if(mc_muzikc_open){
            if(mc_muzikc_list_open){
                $('.mc_muzikc-pl').slideUp(200);
                mc_muzikc_list_open = false;
            }
            $('.mc_muzikc-open i').text("keyboard_arrow_up");
            $('.mc_muzikc').animate({'bottom':"-48px"},200);
            mc_muzikc_open = false;
        }else{
            $('.mc_muzikc-open i').text("keyboard_arrow_down");
            $('.mc_muzikc').animate({'bottom':0},200);
            mc_muzikc_open = true;
        }
    });
    $(document).on('click', '.mc_muzikc-list-open', function(e){
        if(mc_muzikc_list_open){
            $('.mc_muzikc-open i').text("keyboard_arrow_up");
            $('.mc_muzikc').animate({'bottom':"-48px"},200);
            $('.mc_muzikc-pl').slideUp(200);
            mc_muzikc_open = false;
            mc_muzikc_list_open = false;
        }else{
            $('.mc_muzikc-open i').text("keyboard_arrow_down");
            $('.mc_muzikc').animate({'bottom':0},200);
            $('.mc_muzikc-pl').slideDown(200);
            mc_muzikc_open = true;
            mc_muzikc_list_open = true;
        }
    });
})(jQuery);