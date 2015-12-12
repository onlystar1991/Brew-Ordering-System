(function($) {
    // Foundation JavaScript
    // Documentation can be found at: http://foundation.zurb.com/docs
    $(document).foundation();

    initSidenavMinHeight();             // call initSidenavMinHeight function
    initWinResize();                    // call initWinResize function
    initModalCloseAction();             // call initModalCloseAction function
    initInputFieldsAutoWidth();         // call initInputFieldsAutoWidth function
    initOrderDetails();                 // call initOrderDetails function
    initDashboardChart();               // call initDashboardChart function
    initDashboardDatePicker();          // call initDashboardDatePicker function
    initChosen();                       // call initChosen function
    log('NotiBrew');
    
    /*
     * This is a custom logger function. 
     * Instead of using 'console.log' 
     * why not cut it short? :)
     * 
     * @param string mesagge The message to output
     * 
     * @return void
     */
    function log(message) {
        console.log(message);
    }
    
    /*
     * Use this logger function if you feel that console.log
     * output is kind of old and boring. We can use this logger
     * to ouput images, then styled text.
     * See link: https://github.com/astoilkov/console.message
     * 
     * @param string message The message to output
     * @param json options The options to configure the output style
     * 
     * @return void
     */
    function logCoolKid(message, options) { 
        console.message()
                .text(message, options)
                .print();
    }
    
    /*
     * This method will identify the height of the screen subtracted 
     * by the height of the header. We'll use the value to set the 
     * minumun height of the sidebar navigation.
     * 
     * @param int height The element height.
     *  
     * @return int
     */
    function getUnusedSpace(height) {
        var winHeight = $(document).height(); // height of the document
        
        return winHeight - height; // return value
    }
    
    /*
     * This will set the sidenav mininum height
     * 
     * @return void
     */
    function initSidenavMinHeight() {
        var header = document.getElementById('header');
        var headerHeight = 0;
        var sidenav = document.getElementById('sidenav');
        var sidenavMinHeight = 0;
        
        // if header is undefined
        if(!header) return; // exit function
        
        // ... proceed
        headerHeight = $(header).height(); // get header height
        sidenavMinHeight = getUnusedSpace(headerHeight); // get the unused height of the window
        
        // if sidenav is undefined
        if(!sidenav) return; // exit function
        
        // ... proceed
        $(sidenav).css('minHeight', sidenavMinHeight + 'px');
    }
    
    /*
     * Listen to resize event of the window.
     * Then update update the sidenav min-height
     * 
     * @return void
     */
    function initWinResize() {
        $(window).resize(function() {
            initSidenavMinHeight();         // call initSidenavMinHeight function
        });
    }
    
    /*
     * Attach custom handler for closing modal dialog.
     * Clicking "No" option will close the current modal.
     * 
     * @return void
     */
    function initModalCloseAction() {
        var closeBtns       = document.getElementById('close-modal'); // get the element
        
        // if element is null
        if(closeBtns === null) return; // exit function
        
        // ... proceed
        var modalId         = '#' + $(closeBtns).data('modal'); // create id reference based on the data-modal attribute of the close button
        
        // attach click event
        $(closeBtns).click(function() {
            $(modalId).foundation('reveal', 'close'); // close the modal
        });
    }
    
    /*
     * Auto resize the input text fields based on the content's size.
     * 
     * @return void
     */
    function initInputFieldsAutoWidth() {
        var textFields      = document.querySelector('input[data-autosize-input]'); // get all the text fields
        
        // if textFields is undefined
        if(!textFields) return; // exit function
        
        // ... proceed
        $(textFields).autosizeInput();
    }
    
    /*
     * Expand the order details to see further information
     * 
     * @return void
     */
    function initOrderDetails() {
        var a                   = document.getElementById('lnk-orderDetails');
        
        // if a is undefined
        if(!a) return; // exit function
        
        // ... proceed
        // attach custom click handler
        $(a).click(function(e) {
            
            var orderDetails     = document.getElementById('orderFullDetails');
            
            // if orderDetails is undefined
            if(!orderDetails) return; // exit callback
            
            // ... proceed
            $(orderDetails).slideToggle(200, function() {
                
                $(this).toggleClass('disabled'); // toggle disable class on button
                
                // update sidebar height
                initSidenavMinHeight();
            });
            
            e.preventDefault();
        });
    }
    
    /*
     * Plot the line chart on the dashboard page canvas.
     * This will generate a line chart based on the specified data.
     * For frontend development purposes, I will use a dummy generated data,
     * however on production the data must be pulled from the persistent database.
     * 
     * @return void
     */
    function initDashboardChart() {
        var statCanvas          = document.getElementById('statCanvas'); 
        var ctx2d;
        
        // check if statCanvas is not null, before manipulating it.
        if(statCanvas === null) return; // exit function
        
        // ... proceed
        ctx2d                   = statCanvas.getContext('2d');
        
        var randomScalingFactor = function(){ return Math.round(Math.random()*40);};
        var lineChartData = {
                labels : ["Jan","Feb","Mar","Apr","May","Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets : [
                        {
                                label: "Yearly",
                                fillColor : "transparent",
                                strokeColor : "#eb6101",
                                data: [1, 65, 59, 80, 81, 56, 55, 40]
                        }
                ]
        };
        
        window.myLine = new Chart(ctx2d).Line(lineChartData, {
                responsive: true,
                
                //String - Colour of the grid lines
                scaleGridLineColor : "#e8e8e8",
                
                //Boolean - Whether to show vertical lines (except Y axis)
                scaleShowVerticalLines: false,                   
                //Boolean - Whether the line is curved between points
                bezierCurve : false,
                
                //Boolean - Whether to show a dot for each point
                pointDot : false,
                
                // String - Template string for single tooltips
                tooltipTemplate: "<%if (value > 1) {%>Orders: <%} else {%>Order: <%}%><%= value %> : <%=label%>",
                
                
                // Function - Determines whether to execute the customTooltips function instead of drawing the built in tooltips (See [Advanced - External Tooltips](#advanced-usage-custom-tooltips))
                customTooltips: iniCustomToolTips
        });
        
        /*
         * Provide custom tooltip for matching the website color scheme
         * 
         * @param object tolltip 
         * 
         * @return void
         */
        function iniCustomToolTips(tooltip) {
            var tooltipEl = $('#chartjs-tooltip');
        
            if (!tooltip) {
                tooltipEl.css({
                    opacity: 0
                });
                return;
            }

            tooltipEl.removeClass('above below');
            tooltipEl.addClass(tooltip.yAlign);
            tooltipEl.addClass(tooltip.xAlign);

            // split out the label and value and make your own tooltip here
            var parts = tooltip.text.split(":");
            var innerHtml = '<span>' + parts[0].trim() + '</span>: <span>' + parts[1].trim() + '</span> ';
            innerHtml    += '<span class="tooltip-label">' + parts[2].trim() + '</span>';
            tooltipEl.html(innerHtml);

            tooltipEl.css({
                opacity: 1,
                left: tooltip.chart.canvas.offsetLeft + tooltip.x + 'px',
                top: tooltip.chart.canvas.offsetTop + (tooltip.y - ($(tooltipEl).height() + 10)) + 'px',
                fontFamily: $(document.body).css('fontFamily'),
                fontSize: $(document.body).css('fontSize'),
                fontStyle: $(document.body).css('fontStyle')
            });
        }
    }
    
    /*
     * Selectable date range on dashboard filter.
     * 
     * @return void
     */
    function initDashboardDatePicker() {
        var dateRange           = document.getElementById('dateRange');
        dateRange               = null;
        
        // if dateRange element is null
        if(dateRange === null) return; // exit function
        log('naa');
        // ... proceed
        $('#dateRange').daterangepicker({locale: { cancelLabel: 'Clear' }  });
    }
    
    /*
     * Make select items as clickable items with options 
     * to remove the items on the fly.
     * 
     * @return void
     */
    function initChosen() {
        var chosenSelect = document.getElementsByClassName('chosen-select');
        
        // if chosenSelect is null
        if(chosenSelect === null) return; // exit function
        
        // ... proceed
        $(chosenSelect).chosen();
    }
})(jQuery);