var HASH = window.location.hash.substr(1);

jQuery(document).ready(function ($) {

    // Call Gridder
    $('.gridder').gridderExpander({
        scroll: true,
        scrollOffset: 10,
        scrollOffsetElement : '#header',
        scrollTo: "panel", // panel or listitem
        animationSpeed: 600,
        animationEasing: "easeInOutExpo",
        showNav: true, // Show Navigation
        nextText: "<span c>&rsaquo;</span>", // Next button text
        prevText: "<span>&lsaquo;</span>", // Previous button text
        closeText: "&#215;", // Close button text
        onStart: function (myBlog) {
            addListeners();
            autoOpenHash($('.showcase-menu [data-filter-slug=' + HASH + '], .gridder-list[data-deeplink=' + HASH + ']'));            
        },

        onLoadContent: function (myBlog) {
            //Gridder Content Loaded
            //console.log('On Gridder Load Content...', myBlog);
        },

        onContent: function (myBlog) {
            //Gridder Content Loaded
            //console.log('On Gridder Expand...', myBlog);
        },
        onClosed: function (myBlog) {
            //Gridder Closed
            //console.log('On Gridder Closed...', myBlog);
        }
    });

    function autoOpenHash(target){        
        if(!HASH || HASH == "undefined" || HASH.length == 0 || target.length == 0) return;
        
        setTimeout(function(){
        	target.trigger('click');    
        }, 500);
        
    }

    function getScrollHeight(){
        return $('#header').height();
    }

    function addListeners(){

        $('.gridder-list').click(function(event){
            var hash = $(this).data('deeplink');
            if(hash && hash.length > 0){
                window.location.hash = '#' + hash;
            }
        });

        $('.gridder-list .overlay a').click(function(event){
            event.preventDefault();
            //window.location.href = $(this).attr('href');

            window.open($(this).attr('href'), "_blank");
            return false;
        });

        $('#showcase-search #searchform').submit(function(event){
            event.preventDefault();
            var _self = $(this);
            
            $.ajax({
                url: _self.attr('action'),
                type: _self.attr('method'),
                dataType: 'json',
                data: _self.serialize(),
                success: function(data) {
                    applySearchFilter(data);
                }
            });
        });

        $('#showcase-search #searchform input[type=text]').on('click', closeMobileNav);

        $('#techology-cloud a').click(function(event){
            event.preventDefault();
            var _self = $(this);
            
            $.ajax({
                url: './?post_type=showcase&s=' + _self.text() + '&taxonomy=' + _self.text(),
                type: 'get',
                dataType: 'json',
                data: _self.serialize(),
                success: function(data) {
                    applySearchFilter(data);
                }
            });

            $('#showcase-search #searchform #s').val('');
            closeResults();
            closeMobileNav();
            return false;
        });

        var $showcaseMenuItems = $('.showcase-menu li');

        $showcaseMenuItems.click(function(event){
            event.preventDefault();
            
            var _self = $(this),
            _slug = _self.data('filter-slug');

            if(_slug && _slug != "undefined" && _slug.length > 0){
                window.location.hash = '#' + _slug;
            }

            $showcaseMenuItems.removeClass('selected');
            $(this).addClass('selected');

            $('#mobile-category-info').text($(this).text());

            $('#showcase-search #searchform #s').val('');
            closeResults();

            TweenLite.to($('.gridder-list'), 0.2, {
                scale:.3,
                alpha:0,
                onComplete:applyCategoriesFilter,
                onCompleteParams:[$(this).data('filter-categorie')]
            });

            closeMobileNav();
            
        });
    }
});

function closeMobileNav(){
    if($('#showcase-menu-navbar').attr('aria-expanded') === "true"){
        $('.navbar-collapse').collapse("hide");        
    }
}


function applyCategoriesFilter(value){
    var _self,
    categorie = value.toString().toLowerCase(),
    cats;

    if(categorie !== '*'){
        $('.gridder-list').each(function(ind, ele){
            _self = $(this);
            cats = String(_self.data('categories')).split(',');            
            if(cats.indexOf(categorie.toString()) > -1){
                //_self.removeClass('hidden');
                //corresponding GSAP transform (tweened over 2 seconds):
                _self.removeClass('hidden');
                TweenLite.to(_self, 0.3, {scale:1, alpha:1});
            }else{
                _self.addClass('hidden');
                TweenLite.to(_self, 0, {scale:0, alpha:0});
            }
        });
    }else{
        $('.gridder-list').removeClass('hidden');
        TweenLite.to($('.gridder-list'), 0.3, {scale:1, alpha:1});
    }

}


function applySearchFilter(data){
    closeResults();
    TweenLite.to($('.gridder-list'), 0.2, {
        scale:.3,
        alpha:0,
        onComplete:showSearchResult,
        onCompleteParams:[data]
    });
}

function showSearchResult(data){

    var _self,
    pin = 0,
    i;

    $('.gridder-list').each(function(ind, ele){
        _self =  $(this);
        if(data.indexOf(_self.data('postid')) > -1){
            _self.removeClass('hidden');
            TweenLite.to(_self, 0.3, {scale:1, alpha:1});
            pin++;
        }else{
            _self.addClass('hidden');
            TweenLite.to(_self, 0, {scale:0, alpha:0});
        }        
    });

    if(pin == 0){
        $('.noentries').addClass('show');
    }else{
        $('.noentries').removeClass('show');
    }
}

function closeResults(){
    $('.gridder-close').trigger("click");
    $('.noentries').removeClass('show');    
}