$(document).ready(function () {
    var navBtn = $('.nav-menu-link');
    var nav = $('.nav-content');
    navBtn.click(function () {
        nav.toggleClass('active');
    });
    $(document).mouseup(e => {
        if (!nav.is(e.target) // if the target of the click isn't the container...
            &&
            nav.has(e.target).length === 0) // ... nor a descendant of the container
        {
            nav.removeClass('active');
        }
    });
});