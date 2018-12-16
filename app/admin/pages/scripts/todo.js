/**
Todo Module
**/
var Todo = function () {

    // private functions & variables

    var _initComponents = function() {
        
        // init datepicker
        $('.todo-taskbody-due').datepicker({
            rtl: Metronic.isRTL(),
            orientation: "left",
            autoclose: true
        });

        // init tags        
        $(".todo-taskbody-tags").select2({
            tags: ["Testing", "Important", "Info", "Pending", "Completed", "Requested", "Approved"]
        });
    }

    var _handleProjectListMenu = function() {
        if (Metronic.getViewPort().width <= 992) {
            $('.todo-project-list-content').addClass("collapse");
        } else {
            $('.todo-project-list-content').removeClass("collapse").css("height", "auto");
        }
    }

    $(".todo-tasklist-item a").click(function(){
        $(".loading-block").removeClass("hide");
        $.ajax({
            type: "GET",
            cache: false,
            url: '/tickets/view/'+$(this).data('ticket-id'),
            dataType: "html",
            success: function(res) {
                $(".loading-block").addClass("hide");
                $("#ticketView").html( res );
            },
            error: function(xhr, ajaxOptions, thrownError) {
                var msg = 'Error on reloading the content. Please check your connection and try again.';
                alert(msg);
            }
        });



    });

    // public functions
    return {

        //main function
        init: function () {
            _initComponents();     
            _handleProjectListMenu();

            Metronic.addResizeHandler(function(){
                _handleProjectListMenu();    
            });       
        }

    };

}();