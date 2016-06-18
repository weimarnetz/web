<link rel="stylesheet" type="text/css" href="/inc/jquery.mCustomScrollbar.min.css" />
<link rel="stylesheet" type="text/css" href="/inc/timeline.css"/>
<link rel="stylesheet" type="text/css" href="/inc/custom.css"/>
<script src="/inc/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/inc/timeline.js"></script>
<script>
$(document).ready(function() {
$('#events').communityTimeline({
                disableScroll : true,
                source : 'weimarnetz',
                limit : 3,
                title : null,
                order : 'newest-first'
        });

});
</script>
