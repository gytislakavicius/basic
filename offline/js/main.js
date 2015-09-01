$(function() {
  $('.js-nav-trigger').click(function(event) {
    event.preventDefault();

    $('.modal__window').fadeOut('fast');
    $('body').removeClass('modal-opened');

    if ($('.sidebar').hasClass('opened')) {
      $('.sidebar').toggleClass('opened');
    }

    var target = $(this).attr('href'),
        menuLink = $('.navigation > li');

    menuLink.removeClass('active');

    if ($(this).hasClass('scroll__down')) {
      $.each(menuLink, function() {
        var element = $(this).find('a');

        if (element.attr('href') === target) {
          element.parent().addClass('active');
        }
      });
    }

    $(this).parent('li').addClass('active');
    $('html, body').animate({
        scrollTop: $(target).offset().top
    }, 500);
  });

  $('.navigation__hamburger').click(function(event) {
    event.preventDefault();

    $('.sidebar').toggleClass('opened');
  });

	var top_left = new Vivus('line_top_left', {type: 'delayed', duration: 150, start: 'autostart'}, function() {});
  var top_right = new Vivus('line_top_right', {type: 'delayed', duration: 150, start: 'autostart'}, function() {});
  var bottom_left = new Vivus('line_bottom_left', {type: 'delayed', duration: 150, start: 'autostart'}, function() {});
  var bottom_right = new Vivus('line_bottom_right', {type: 'delayed', duration: 150, start: 'autostart'}, function() {});

  $('.modal-trigger').click(function() {
    var target = $(this).data('modal');

    if (target !== 'undefined') {
      $('body').addClass('modal-opened');
      $('#' + target).fadeIn('fast');
    }
  });

  $('.close-modal').click(function(e) {
    e.preventDefault();
    $('body').removeClass('modal-opened');
    $('.modal__window').fadeOut('fast');
  });
});
