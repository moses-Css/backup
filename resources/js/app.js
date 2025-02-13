import './bootstrap';
import '../css/app.css';


$(function() {
    $('#dateRange').daterangepicker({
        opens: 'left',
        locale: {
            format: 'MMM DD, YYYY'
        },
        startDate: 'Sep 19, 2026',
        endDate: 'Dec 19, 2026'
    }, function(start, end, label) {
        $('#dateRange').val(start.format('MMM DD, YYYY') + ' - ' + end.format('MMM DD, YYYY'));
    });
});