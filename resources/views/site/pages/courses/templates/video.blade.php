<div class="modal-content">
    @if ($link_status == 'yes')
        <div id="player1"></div>
    @else
        <div class="alert alert-danger text-center">
            الفيديو تحت الإنشاء
        </div>
    @endif

</div>

<script>
    var player = new Clappr.Player({
        source: "{{ $video->link_url }}",
        autoPlay: false,
        height: 500,
        width: '100%',
        parentId: "#player1",
        plugins: [LevelSelector],
        levelSelectorConfig: {
            title: 'Quality',
            labels: {
                4: '',
                3: '',
                1: '', // 240kbps
                2: '', // 500kbps
                0: '', // 120kbps
            },
            labelCallback: function(playbackLevel, customLabel) {
                return customLabel + playbackLevel.level.height + 'p'; // High 720p
            }
        },
    });
</script>
