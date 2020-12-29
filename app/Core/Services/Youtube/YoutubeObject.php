<?php


namespace App\Core\Services\Youtube;


class YoutubeObject
{
    private string $path = '';
    private string $filename;
    private string $fileExt = '.mp3';
    private string $url;

    private string $thumbPath;
    private string $thumbName;
    private string $thumbExt = '.jpg';


    /**
     * /path/to/file.mp3
     * @return string
     */
    public function getFileLocation(): string
    {
        return $this->getPath() . '/' . $this->getFilename() . $this->getFileExt();
    }

    /**
     * /path/to/thumb.jpg
     * @return string
     */
    public function getThumbnailLocation(): string
    {
        return $this->getThumbPath() . '/' . $this->getThumbName() . $this->getThumbExt();
    }

    /**
     * file.mp3
     * @return string
     */
    public function getFileWithExtension(): string
    {
        return $this->getFilename() . $this->getFileExt();
    }

    /**
     * photo.jpg
     * @return string
     */
    public function getThumbnailWithExtension(): string
    {
        return $this->getThumbName() . $this->getThumbExt();
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return YoutubeObject
     */
    public function setPath(string $path): YoutubeObject
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return YoutubeObject
     */
    public function setFilename(string $filename): YoutubeObject
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return string
     */
    public function getThumbPath(): string
    {
        return $this->thumbPath;
    }

    /**
     * @param string $thumbPath
     * @return YoutubeObject
     */
    public function setThumbPath(string $thumbPath): YoutubeObject
    {
        $this->thumbPath = $thumbPath;
        return $this;
    }

    /**
     * @return string
     */
    public function getThumbName(): string
    {
        return $this->thumbName;
    }

    /**
     * @param string $thumbName
     * @return YoutubeObject
     */
    public function setThumbName(string $thumbName): YoutubeObject
    {
        $this->thumbName = $thumbName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFileExt(): string
    {
        return $this->fileExt;
    }

    /**
     * @param string $fileExt
     * @return YoutubeObject
     */
    public function setFileExt(string $fileExt): YoutubeObject
    {
        $this->fileExt = $fileExt;
        return $this;
    }

    /**
     * @return string
     */
    public function getThumbExt(): string
    {
        return $this->thumbExt;
    }

    /**
     * @param string $thumbExt
     * @return YoutubeObject
     */
    public function setThumbExt(string $thumbExt): YoutubeObject
    {
        $this->thumbExt = $thumbExt;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return YoutubeObject
     */
    public function setUrl(string $url): YoutubeObject
    {
        $this->url = $url;
        return $this;
    }

}
