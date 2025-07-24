function mobileMenu() {
    var content = '.site__content';
    var nav = '.site__navigation';

    $('.nav__trigger--open').click(function (e) {
        e.preventDefault();
        $('body').addClass('no-scroll');
        $(nav).addClass('is-open');
        $(content).addClass('add-overlay');
        return false;
    });

    $('.nav__trigger--close').click(function (e) {
        e.preventDefault();
        $('body').removeClass('no-scroll');
        $(nav).removeClass('is-open');
        $(content).removeClass('add-overlay');
        return false;
    });
}
