// Click event handler (depending on platform)
var mobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
var deviceClick;
if (mobile) { // Mobile OS
    deviceClick = 'touchend';
} else { // Desktop
    deviceClick = 'click';
}

function resize() {
    var windowWidth = parseInt($(window).width());
    var windowHeight = parseInt($(window).height());

    if(windowWidth > 1024) {
        $(window).scroll(function(){
            if($(window).scrollTop() >= 32) {
                $('header').addClass('fixed');
            } else {
                $('header').removeClass('fixed');
            }
        });
        
        if($(window).scrollTop() >= 32) {
            $('header').addClass('fixed');
        }
        
        $('.categories-mobile .selected').remove();
        $('.categories-mobile ul').unwrap();
        $('.categories ul').show();
        
        if($('.categories-mobile').length == 0) {
            $('body.products:not(.admin) .overlay').hide();
        }
    } else if(windowWidth <= 1024) {
        categories();
    }
    
    if(mobile) {
        $('body.home:not(.admin-home) #main .bg ul li').css('width', windowWidth + 'px');
    }
}


// Categories (mobile)
function categories() {
    if($('.categories-mobile').length == 0) {
        $('.categories ul').hide();
        $('.categories ul').wrap('<div class="categories-mobile">');
        
        var selectedParent = $('.categories-mobile ul li.active .parent a').text();
        if($('.categories-mobile ul li.active .subcat a.sub-active').length > 0) {
            var selectedSubcat = ' &raquo; ' + $('.categories-mobile ul li.active .subcat a.sub-active').text();
        } else {
            var selectedSubcat = '';
        }
        var selected = selectedParent + selectedSubcat;
        $('.categories-mobile').prepend('<div class="selected"><span>' + selected + '</span><i class="icon-arrow-combo"></i></div>');
    }
}


// Get URL parameter values
$.extend({
    getUrlVars: function(){
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++) {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    },
    getUrlVar: function(name){
        return $.getUrlVars()[name];
    }
});

function loadContent(url) {
    $.getJSON("content.php", {cid: url, format: 'json'}, function(json) {
        $.each(json, function(key, value){
            $(key).html(value);
        });
    });
    $('.product').removeClass('current');
    $('a[href="'+url+'"]').closest('.product').addClass('current');
}


$(document).ready(function() {
    
    resize();
    $(window).bind('resize', resize);
    
    // Active menu highlight
    var activePage = $('body');
    var activeMenu = $('header .main-nav');
    var adminMenu = $('#admin-menu');
    if(!activePage.hasClass('admin')) {
        if(activePage.hasClass('home')) {
            activeMenu.find('li[data-content="home"]').addClass('active');
        } else if(activePage.hasClass('products')) {
            activeMenu.find('li[data-content="products"]').addClass('active');
        } else if(activePage.hasClass('services')) {
            activeMenu.find('li[data-content="services"]').addClass('active');
        } else if(activePage.hasClass('guides')) {
            activeMenu.find('li[data-content="guides"]').addClass('active');
        } else if(activePage.hasClass('about')) {
            activeMenu.find('li[data-content="about"]').addClass('active');
        } else if(activePage.hasClass('contact')) {
            activeMenu.find('li').removeClass('active');
            activeMenu.find('li[data-content="contact"]').addClass('active');
        }
    } else {
        if(activePage.hasClass('admin-home')) {
            adminMenu.find('li').removeClass('active');
            adminMenu.find('li[data-content="admin-home"]').addClass('active');
        } else if(activePage.hasClass('admin-products')) {
            adminMenu.find('li').removeClass('active');
            adminMenu.find('li[data-content="admin-products"]').addClass('active');
        } else if(activePage.hasClass('admin-services')) {
            adminMenu.find('li').removeClass('active');
            adminMenu.find('li[data-content="admin-services"]').addClass('active');
        } else if(activePage.hasClass('admin-guides')) {
            adminMenu.find('li').removeClass('active');
            adminMenu.find('li[data-content="admin-guides"]').addClass('active');
        } else if(activePage.hasClass('admin-about')) {
            adminMenu.find('li').removeClass('active');
            adminMenu.find('li[data-content="admin-about"]').addClass('active');
        } else if(activePage.hasClass('admin-contact')) {
            adminMenu.find('li').removeClass('active');
            adminMenu.find('li[data-content="admin-contact"]').addClass('active');
        }
    }
    
    // Mobile menu toggle
    $('header .toggle').on('click', function() {
        $(this).find('i').toggleClass('icon-menu icon-cancel');
        $('header .mobile').toggleClass('active');
    });
    
    
    // Custom select boxes
    $('select').selectBox({
        mobile: true,
        menuTransition: 'default',
        hideOnWindowScroll: false
    });
    
    // Search box
    $('#search-text, #add-category, #add-subcategory').focus(function() {
        $(this).closest('form').addClass('focused');
    });
    $('#search-text, #add-category, #add-subcategory').blur(function() {
        if($(this).val() == '') {
            $(this).closest('form').removeClass('focused');
        }
    });
    
    // Remove item
    $('body:not(.admin-guides) .product .remove').on('click', function() {
        var productId = $(this).closest('.product').attr('data-product');
        $('.overlay').show();
        $('#main').append('<div class="remove-product" data-product="' + productId + '"><h3>Är du säker?</h3><a href="/admin/removeProduct?id=' + productId + '" class="remove">Ta bort</a><a class="cancel">Avbryt</a></div>');
    });
    $('#main').on('click', '.remove-product .cancel', function() {
        $('.remove-product').remove();
        $('.overlay').hide();
    });
    
    // Categories (mobile)
    $('.categories').on('click', '.categories-mobile .selected', function() {
        $('.overlay').show();
        $('.categories-mobile ul').show();
    });
    
    // Overlay
    $('.overlay').on('click', function() {
        $('.popup, .remove-product').remove();
        $(this).hide();
        $('.categories-mobile ul').hide();
        $('.articleGroup-selectBox-dropdown-menu, .aGroup-selectBox-dropdown-menu').remove();
        if($('body').hasClass('admin-products')) {
            history.pushState('', 'Reset URL', '/admin/produkter');
            e.preventDefault();
        } else if($('body').hasClass('admin-about')) {
            history.pushState('', 'Reset URL', '/admin/om-oss');
            e.preventDefault();
        } else if($('body').hasClass('admin-guides')) {
            history.pushState('', 'Reset URL', '/admin/guides');
            e.preventDefault();
        } else if($('body').hasClass('admin-services')) {
            history.pushState('', 'Reset URL', '/admin/services');
            e.preventDefault();
        } else if($('body').hasClass('admin-home')) {
            history.pushState('', 'Reset URL', '/admin');
            e.preventDefault();
        }
    });
    
    
    // Edit product
    $('.product .edit').on('click', function(e) {
        $('.overlay').show();
        
        var href = $(this).attr("href");
        history.pushState('', 'New URL: '+href, href);
        e.preventDefault();
        $(function(e) {
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                data: formData,
                url: '/editProduct' + href,
                success: function(data) {
                    $('#main').append(data);
                }
            });
        });
    });
    
    
    // Add product
    $('.add-product').on('click', function(e) {
        $('.overlay').show();
        
        var href = $(this).attr("href");
        history.pushState('', 'New URL: '+href, href);
        e.preventDefault();
        $(function(e) {
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                data: formData,
                url: '/addProduct',
                success: function(data) {
                    $('#main').append(data);
                }
            });
        });
    });
    
    
    // Edit colleague
    $('.colleague .edit').on('click', function(e) {
        $('.overlay').show();
        
        var href = $(this).attr("href");
        history.pushState('', 'New URL: '+href, href);
        e.preventDefault();
        $(function(e) {
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                data: formData,
                url: '/editColleague' + href,
                success: function(data) {
                    $('#main').append(data);
                }
            });
        });
    });
    
    
    // Add colleague
    $('.add-colleague').on('click', function(e) {
        $('.overlay').show();
        
        var href = $(this).attr("href");
        history.pushState('', 'New URL: '+href, href);
        e.preventDefault();
        $(function(e) {
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                data: formData,
                url: '/addColleague',
                success: function(data) {
                    $('#main').append(data);
                }
            });
        });
    });
    
    
    // Edit colleague
    $('.bg-item .edit').on('click', function(e) {
        $('.overlay').show();
        
        var href = $(this).attr("href");
        history.pushState('', 'New URL: '+href, href);
        e.preventDefault();
        $(function(e) {
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                data: formData,
                url: '/editSlideshow' + href,
                success: function(data) {
                    $('#main').append(data);
                }
            });
        });
    });
    
    
    // Add colleague
    $('.add-guide').on('click', function(e) {
        $('.overlay').show();
        
        var href = $(this).attr("href");
        history.pushState('', 'New URL: '+href, href);
        e.preventDefault();
        $(function(e) {
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                data: formData,
                url: '/addGuide',
                success: function(data) {
                    $('#main').append(data);
                }
            });
        });
    });
    
    
    // Prevent enter-action if field is empty
    $('#add-category, #add-subcategory, #search-text').on('keyup', function() {
        if($(this).val() == '') {
            $(this).next().addClass('disabled');
        } else {
            $(this).next().removeClass('disabled');
        }
    });
    $('#add-category, #add-subcategory, #search-text').on('keypress', function(e) {
        if($(this).val() == '') {
            if(e.which == 13) {
                e.preventDefault();
            }
        }
    });
    
    
});