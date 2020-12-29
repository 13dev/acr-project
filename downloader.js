const YoutubeMp3Downloader = require("youtube-mp3-downloader")
const argv = require('minimist')(process.argv.slice(2))

function getYouTubeId(data) {
    if (!(/^[a-zA-Z0-9-_]{11}$/.test(data))) {
        let videoId = data.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
        if (videoId != null) {
            return videoId[1];
        }
        return false;
    }

    return data;
}

const videoId = getYouTubeId(argv.url)

const options = JSON.parse(JSON.stringify(argv.options))
// {
//     "ffmpegPath": "/usr/bin/ffmpeg",        // FFmpeg binary location
//     "outputPath": "/var/www/html",    // Output file location (default: the home directory)
//     "youtubeVideoQuality": "highestaudio",  // Desired video quality (default: highestaudio)
//     "queueParallelism": 2,                  // Download parallelism (default: 1)
//     "progressTimeout": 2000,                // Interval in ms for the progress reports (default: 1000)
//     "allowWebm": false                      // Enable download from WebM sources (default: false)
// }
//
//Configure YoutubeMp3Downloader with your settings
const downloader = new YoutubeMp3Downloader(options)

//Download video and save as MP3 file
downloader.download(videoId, options.outputName)

downloader.on('progress', progress => {
    console.log(JSON.stringify(progress))
});

downloader.on('finished', (err, data) => {
    console.log(JSON.stringify(data))
    process.exit(0)
});

downloader.on('error', error => {
    console.log(error)
    process.exit(1)
});


