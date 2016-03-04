<section>

<a class="sublime zoomable" href="#video_wrapper" data-settings="close-button-position:right">
  <img src="http://media.sublimevideo.net/vpa/ms_800.jpg" width="320" height="180" />
  <span class="zoom_icon"></span>
</a>

<video controls id="video_wrapper" data-settings="uid:demo-lightbox-close-button-position; autoresize:fit;" title="Demo: Lightbox, Close button position" poster="http://media.sublimevideo.net/vpa/ms_800.jpg" width="640" height="360" preload="none" style="display:none">
  <source src="http://media.sublimevideo.net/vpa/ms_360p.mp4" type="video/mp4"/>
  Your browser does not support the video tag.
</video>


</section>
<script>
$(document).ready(function() {
	
var current_source = $('.mp4_source').attr('src');

if (current_source != video_location_mp4) {
    var current_width = $('#video_wrapper').width();
    var current_height = $('#video_wrapper').height();

    var new_video_wrapper = $('<div id="video_wrapper"></div>');
    var new_video_player = $('<video id="video_player"></video>')
                             .addClass('sublime')
                             .attr('width', current_width)
                             .attr('height', current_height)
                             .attr('preload', 'none')
                             .attr('data-uid', video_id)
                             .attr('data-name', viddata['subject'])
                             .attr('data-autoresize', 'fit');
    var new_source = $('<source src="' + video_location_mp4 + '"></source>')
                             .addClass('mp4_source');

    new_video_player.append(new_source);
    new_video_wrapper.append(new_video_player);

    $('#video_wrapper').remove();
    new_video_wrapper.insertBefore('#videoinfo');
    sublime.prepare('video_player', function(player) {
        player.on('metadata', function(player) {
            player.seekTo(timestamp);
        });
        player.play();
    });
} else {
    var player = sublime.player('video_player');
    player.seekTo(timestamp);
    player.play();
}
	
})

</script>