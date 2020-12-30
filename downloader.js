const YoutubeMp3Downloader = require("youtube-mp3-downloader")
const argv = require('minimist')(process.argv.slice(2))
// {
//     "ffmpegPath": "/usr/bin/ffmpeg",        // FFmpeg binary location
//     "outputPath": "/var/www/html",    // Output file location (default: the home directory)
//     "youtubeVideoQuality": "highestaudio",  // Desired video quality (default: highestaudio)
//     "queueParallelism": 2,                  // Download parallelism (default: 1)
//     "progressTimeout": 2000,                // Interval in ms for the progress reports (default: 1000)
//     "allowWebm": false                      // Enable download from WebM sources (default: false)
// }
let options = JSON.parse(argv.options.replace(/'/g, ''))

//Configure YoutubeMp3Downloader with your settings
const downloader = new YoutubeMp3Downloader(options)

//Download video and save as MP3 file
downloader.download(argv.id, options.outputName + '.mp3')

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


