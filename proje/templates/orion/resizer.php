<?php
global $ALLOWED_SITES;

if (!defined('DEBUG_ON')) {
    define('DEBUG_ON', FALSE);
}
if (!defined('DEBUG_LEVEL')) {
    define('DEBUG_LEVEL', 1);
}
if (!defined('DISPLAY_ERROR_MESSAGES')) {
    define('DISPLAY_ERROR_MESSAGES', TRUE);
}
if (!defined('ALLOW_EXTERNAL')) {
    define('ALLOW_EXTERNAL', FALSE);
}

if (!isset($ALLOWED_SITES)) {
    $ALLOWED_SITES = array(
        'flickr.com',
        'staticflickr.com',
        'img.youtube.com',
        'upload.wikimedia.org',
        'imgur.com',
        'imageshack.us',
        'tinypic.com'
    );
}
if (!defined('FILE_CACHE_ENABLED')) {
    define('FILE_CACHE_ENABLED', TRUE);
}
if (!defined('DAY_IN_SECONDS')) {
    define('DAY_IN_SECONDS', 24 * 60 * 60);
}
if (!defined('FILE_CACHE_TIME_BETWEEN_CLEANS')) {
    define('FILE_CACHE_TIME_BETWEEN_CLEANS', DAY_IN_SECONDS * 30);
}
if (!defined('FILE_CACHE_MAX_FILE_AGE')) {
    define('FILE_CACHE_MAX_FILE_AGE', DAY_IN_SECONDS * 60);
}
if (!defined('FILE_CACHE_SUFFIX')) {
    define('FILE_CACHE_SUFFIX', '.txt');
}
if (!defined('FILE_CACHE_PREFIX')) {
    define('FILE_CACHE_PREFIX', 'newImage');
}
if (!defined('FILE_CACHE_DIRECTORY')) {
    define('FILE_CACHE_DIRECTORY', FALSE);
}
if (!defined('TEN_MB_IN_BTYES')) {
    define('TEN_MB_IN_BTYES', 10485760);
}
if (!defined('MAX_FILE_SIZE')) {
    define('MAX_FILE_SIZE', TEN_MB_IN_BTYES * 2);
}
if (!defined('CURL_TIMEOUT')) {
    define('CURL_TIMEOUT', 20);
}
if (!defined('WAIT_BETWEEN_FETCH_ERRORS')) {
    define('WAIT_BETWEEN_FETCH_ERRORS', 3600);
}
if (!defined('BROWSER_CACHE_MAX_AGE')) {
    define('BROWSER_CACHE_MAX_AGE', DAY_IN_SECONDS * 30);
}
if (!defined('BROWSER_CACHE_DISABLE')) {
    define('BROWSER_CACHE_DISABLE', FALSE);
}
if (!defined('MAX_WIDTH')) {
    define('MAX_WIDTH', 3200);
}
if (!defined('MAX_HEIGHT')) {
    define('MAX_HEIGHT', 3200);
}
if (!defined('PNG_IS_TRANSPARENT')) {
    define('PNG_IS_TRANSPARENT', TRUE);
}
if (!defined('DEFAULT_Q')) {
    define('DEFAULT_Q', 85);
}
if (!defined('DEFAULT_ZC')) {
    define('DEFAULT_ZC', 1);
}
if (!defined('DEFAULT_F')) {
    define('DEFAULT_F', '');
}
if (!defined('DEFAULT_S')) {
    define('DEFAULT_S', 0);
}
if (!defined('DEFAULT_CC')) {
    define('DEFAULT_CC', 'ffffff');
}
if (!defined('DEFAULT_WIDTH')) {
    define('DEFAULT_WIDTH', 125);
}
if (!defined('DEFAULT_HEIGHT')) {
    define('DEFAULT_HEIGHT', 125);
}
if (!defined('OPTIPNG_ENABLED')) {
    define('OPTIPNG_ENABLED', TRUE);
}
if (!defined('OPTIPNG_PATH')) {
    define('OPTIPNG_PATH', '/usr/bin/optipng');
}
if (!defined('PNGCRUSH_ENABLED')) {
    define('PNGCRUSH_ENABLED', TRUE);
}
if (!defined('PNGCRUSH_PATH')) {
    define('PNGCRUSH_PATH', '/usr/bin/pngcrush');
}
if (!class_exists('resizer')): {
    class resizer
    {
        protected $src = "";
        protected $is404 = FALSE;
        protected $docRoot = "";
        protected $lastURLError = FALSE;
        protected $localImage = "";
        protected $localImageMTime = 0;
        protected $url = FALSE;
        protected $myHost = "";
        protected $isURL = FALSE;
        protected $cachefile = '';
        protected $errors = array();
        protected $toDeletes = array();
        protected $cacheDirectory = '';
        protected $startTime = 0;
        protected $lastBenchTime = 0;
        protected $cropTop = FALSE;
        protected $salt = "";
        protected $fileCacheVersion = 1;
        protected $filePrependSecurityBlock = "<?php die('Execution denied!'); //";
        protected static $curlDataWritten = 0;
        protected static $curlFH = FALSE;

        public static function start()
        {
            $resizer = new resizer();
            $resizer->handleErrors();
            if ($resizer->tryBrowserCache()) {
                exit(0);
            }
            $resizer->handleErrors();
            if (FILE_CACHE_ENABLED && $resizer->tryServerCache()) {
                exit(0);
            }
            $resizer->handleErrors();
            $resizer->run();
            $resizer->handleErrors();
            exit(0);
        }

        public function __construct()
        {
            global $ALLOWED_SITES;
            $this->startTime = microtime(TRUE);
            date_default_timezone_set('UTC');
            $this->debug(1, "Starting new request from " . $this->getIP() . " to " . $_SERVER['REQUEST_URI']);
            $this->calcDocRoot();
            $this->salt = @filemtime(__FILE__) . '-' . @fileinode(__FILE__);
            $this->debug(3, "Salt is: " . $this->salt);
            if (FILE_CACHE_DIRECTORY) {
                if (!is_dir(FILE_CACHE_DIRECTORY)) {
                    @mkdir(FILE_CACHE_DIRECTORY);
                    if (!is_dir(FILE_CACHE_DIRECTORY)) {
                        $this->error("Could not create the file cache directory.");
                        return FALSE;
                    }
                }
                $this->cacheDirectory = FILE_CACHE_DIRECTORY;
                if (!touch($this->cacheDirectory . '/index.html')) {
                    $this->error("Could not create the index.html file - to fix this create an empty file named index.html file in the cache directory.");
                }
            } else {
                $this->cacheDirectory = sys_get_temp_dir();
            }
            $this->cleanCache();
            $this->myHost = preg_replace('/^www\./i', '', $_SERVER['HTTP_HOST']);
            $new_dev_url = '';
            if (strstr($this->param('src'), '~')) {
                $url_parts = explode('/', $this->param('src'));
                foreach ($url_parts as $url_part) {
                    if (!strstr($url_part, '~')) {
                        $new_dev_url .= $url_part . '/';
                    }
                }
                $new_dev_url = substr($new_dev_url, 0, -1);
                $this->src = $new_dev_url;
            } else {
                $this->src = $this->param('src');
            }
            $this->url = parse_url($this->src);
            $this->src = preg_replace('/https?:\/\/(?:www\.)?' . $this->myHost . '/i', '', $this->src);
            if (strlen($this->src) <= 3) {
                $this->error("No image specified");
                return FALSE;
            }
            if (array_key_exists('HTTP_REFERER', $_SERVER) && (!preg_match('/^https?:\/\/(?:www\.)?' . $this->myHost . '(?:$|\/)/i', $_SERVER['HTTP_REFERER']))) {
                $imgData = base64_decode("R0lGODlhUAAMAIAAAP8AAP///yH5BAAHAP8ALAAAAABQAAwAAAJpjI+py+0Po5y0OgAMjjv01YUZ\nOGplhWXfNa6JCLnWkXplrcBmW+spbwvaVr/cDyg7IoFC2KbYVC2NQ5MQ4ZNao9Ynzjl9ScNYpneb\nDULB3RP6JuPuaGfuuV4fumf8PuvqFyhYtjdoeFgAADs=");
                header('Content-Type: image/gif');
                header('Content-Length: ' . strlen($imgData));
                header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
                header("Pragma: no-cache");
                header('Expires: ' . gmdate('D, d M Y H:i:s', time()));
                echo $imgData;
                return FALSE;
                exit(0);
            }
            if (preg_match('/^https?:\/\/[^\/]+/i', $this->src)) {
                $this->debug(2, "Is a request for an external URL: " . $this->src);
                $this->isURL = TRUE;
            } else {
                $this->debug(2, "Is a request for an internal file: " . $this->src);
            }
            if ($this->isURL && (!ALLOW_EXTERNAL)) {
                $this->error("You are not allowed to fetch images from an external website.");
                return FALSE;
            }
            if ($this->isURL) {
                $this->debug(2, "Fetching only from selected external sites is enabled.");
                $allowed = FALSE;
                foreach ($ALLOWED_SITES as $site) {
                    if ((strtolower(substr($this->url['host'], -strlen($site) - 1)) === strtolower(".$site")) || (strtolower($this->url['host']) === strtolower($site))) {
                        $this->debug(3, "URL hostname {$this->url['host']} matches $site so allowing.");
                        $allowed = TRUE;
                    }
                }
                if (!$allowed) {
                    return $this->error("You may not fetch images from that site. To enable this site in resizer, you can either add it to \$ALLOWED_SITES and set ALLOW_EXTERNAL=true.");
                }
            }
            $cachePrefix = ($this->isURL ? '_ext_' : '_int_');
            if ($this->isURL) {
                $arr = explode('&', $_SERVER['QUERY_STRING']);
                asort($arr);
                $this->cachefile = $this->cacheDirectory . '/' . FILE_CACHE_PREFIX . $cachePrefix . md5($this->salt . implode('', $arr) . $this->fileCacheVersion) . FILE_CACHE_SUFFIX;
            } else {
                $this->localImage = $this->getLocalImagePath($this->src);
                if (!$this->localImage) {
                    $this->debug(1, "Could not find the local image: {$this->localImage}");
                    $this->error("Could not find the internal image you specified.");
                    $this->set404();
                    return FALSE;
                }
                $this->debug(1, "Local image path is {$this->localImage}");
                $this->localImageMTime = @filemtime($this->localImage);
                $this->cachefile = $this->cacheDirectory . '/' . FILE_CACHE_PREFIX . $cachePrefix . md5($this->salt . $this->localImageMTime . $_SERVER['QUERY_STRING'] . $this->fileCacheVersion) . FILE_CACHE_SUFFIX;
            }
            $this->debug(2, "Cache file is: " . $this->cachefile);
            return TRUE;
        }

        public function __destruct()
        {
            foreach ($this->toDeletes as $del) {
                $this->debug(2, "Deleting temp file $del");
                @unlink($del);
            }
        }

        public function run()
        {
            if ($this->isURL) {
                if (!ALLOW_EXTERNAL) {
                    $this->debug(1, "Got a request for an external image but ALLOW_EXTERNAL is disabled so returning error msg.");
                    $this->error("You are not allowed to fetch images from an external website.");
                    return FALSE;
                }
                $this->debug(3, "Got request for external image. Starting serveExternalImage.");
                $this->serveExternalImage();
            } else {
                $this->debug(3, "Got request for internal image. Starting serveInternalImage");
                $this->serveInternalImage();
            }
            return TRUE;
        }

        protected function handleErrors()
        {
            if ($this->haveErrors()) {
                $this->serveErrors();
                exit(0);
            }
            return FALSE;
        }

        protected function tryBrowserCache()
        {
            if (BROWSER_CACHE_DISABLE) {
                $this->debug(3, "Browser caching is disabled");
                return FALSE;
            }
            if (!empty($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
                $this->debug(3, "Got a conditional get");
                $mtime = FALSE;
                if (!is_file($this->cachefile)) {
                    return FALSE;
                }
                if ($this->localImageMTime) {
                    $mtime = $this->localImageMTime;
                    $this->debug(3, "Local real file's modification time is $mtime");
                } else {
                    if (is_file($this->cachefile)) {
                        $mtime = @filemtime($this->cachefile);
                        $this->debug(3, "Cached file's modification time is $mtime");
                    }
                }
                if (!$mtime) {
                    return FALSE;
                }
                $iftime = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
                $this->debug(3, "The conditional get's if-modified-since unixtime is $iftime");
                if ($iftime < 1) {
                    $this->debug(3, "Got an invalid conditional get modified since time. Returning false.");
                    return FALSE;
                }
                if ($iftime < $mtime) {
                    $this->debug(3, "File has been modified since last fetch.");
                    return FALSE;
                } else {
                    $this->debug(3, "File has not been modified since last get, so serving a 304.");
                    header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
                    $this->debug(1, "Returning 304 not modified");
                    return TRUE;
                }
            }
            return FALSE;
        }

        protected function tryServerCache()
        {
            $this->debug(3, "Trying server cache");
            if (file_exists($this->cachefile)) {
                $this->debug(3, "Cachefile {$this->cachefile} exists");
                if ($this->isURL) {
                    $this->debug(3, "This is an external request, so checking if the cachefile is empty which means the request failed previously.");
                    if (filesize($this->cachefile) < 1) {
                        $this->debug(3, "Found an empty cachefile indicating a failed earlier request. Checking how old it is.");
                        if (time() - @filemtime($this->cachefile) > WAIT_BETWEEN_FETCH_ERRORS) {
                            $this->debug(3, "File is older than " . WAIT_BETWEEN_FETCH_ERRORS . " seconds. Deleting and returning false so app can try and load file.");
                            @unlink($this->cachefile);
                            return FALSE;
                        } else {
                            $this->debug(3, "Empty cachefile is still fresh so returning message saying we had an error fetching this image from remote host.");
                            $this->set404();
                            $this->error("An error occured fetching image.");
                            return FALSE;
                        }
                    }
                } else {
                    $this->debug(3, "Trying to serve cachefile {$this->cachefile}");
                }
                if ($this->serveCacheFile()) {
                    $this->debug(3, "Succesfully served cachefile {$this->cachefile}");
                    return TRUE;
                } else {
                    $this->debug(3, "Failed to serve cachefile {$this->cachefile} - Deleting it from cache.");
                    @unlink($this->cachefile);
                    return TRUE;
                }
            }
        }

        protected function error($err)
        {
            $this->debug(3, "Adding error message: $err");
            $this->errors[] = $err;
            return FALSE;
        }

        protected function haveErrors()
        {
            if (sizeof($this->errors) > 0) {
                return TRUE;
            }
            return FALSE;
        }

        protected function serveErrors()
        {
            if (!DISPLAY_ERROR_MESSAGES) {
                return;
            }
            header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
            $html = '<ul>';
            foreach ($this->errors as $err) {
                $html .= '<li>' . htmlentities($err) . '</li>';
            }
            $html .= '</ul>';
            echo '<h1>An error has occured</h1>The following error(s) occured:<br />' . $html . '<br />';
            echo '<br />Query String: ' . htmlentities($_SERVER['QUERY_STRING'], ENT_QUOTES);
        }

        protected function serveInternalImage()
        {
            $this->debug(3, "Local image path is $this->localImage");
            if (!$this->localImage) {
                $this->sanityFail("localImage not set after verifying it earlier in the code.");
                return FALSE;
            }
            $fileSize = filesize($this->localImage);
            if ($fileSize > MAX_FILE_SIZE) {
                $this->error("The file you specified is greater than the maximum allowed file size.");
                return FALSE;
            }
            if ($fileSize <= 0) {
                $this->error("The file you specified is <= 0 bytes.");
                return FALSE;
            }
            $this->debug(3, "Calling processImageAndWriteToCache() for local image.");
            if ($this->processImageAndWriteToCache($this->localImage)) {
                $this->serveCacheFile();
                return TRUE;
            } else {
                return FALSE;
            }
        }

        protected function serveExternalImage()
        {
            if (!preg_match('/^https?:\/\/[a-zA-Z0-9\-\.]+/i', $this->src)) {
                $this->error("Invalid URL supplied.");
                return FALSE;
            }
            $tempfile = tempnam($this->cacheDirectory, 'resizer');
            $this->debug(3, "Fetching external image into temporary file $tempfile");
            $this->toDelete($tempfile);
            if (!$this->getURL($this->src, $tempfile)) {
                @unlink($this->cachefile);
                touch($this->cachefile);
                $this->debug(3, "Error fetching URL: " . $this->lastURLError);
                $this->error("Error reading the URL you specified from remote host." . $this->lastURLError);
                return FALSE;
            }
            $mimeType = $this->getMimeType($tempfile);
            if (!preg_match("/^image\/(?:jpg|jpeg|gif|png)$/i", $mimeType)) {
                $this->debug(3, "Remote file has invalid mime type: $mimeType");
                @unlink($this->cachefile);
                touch($this->cachefile);
                $this->error("The remote file is not a valid image. Mimetype = '" . $mimeType . "'" . $tempfile);
                return FALSE;
            }
            if ($this->processImageAndWriteToCache($tempfile)) {
                $this->debug(3, "Image processed succesfully. Serving from cache");
                return $this->serveCacheFile();
            } else {
                return FALSE;
            }
        }

        protected function cleanCache()
        {
            if (FILE_CACHE_TIME_BETWEEN_CLEANS < 0) {
                return;
            }
            $this->debug(3, "cleanCache() called");
            $lastCleanFile = $this->cacheDirectory . '/cacheLastCleanTime.touch';
            if (!is_writable($lastCleanFile)) {
                return;
            }
            if (!is_file($lastCleanFile)) {
                $this->debug(1, "File tracking last clean doesn't exist. Creating $lastCleanFile");
                if (!touch($lastCleanFile)) {
                    $this->error("Could not create cache clean timestamp file.");
                }
                return;
            }
            if (@filemtime($lastCleanFile) < (time() - FILE_CACHE_TIME_BETWEEN_CLEANS)) {
                $this->debug(1, "Cache was last cleaned more than " . FILE_CACHE_TIME_BETWEEN_CLEANS . " seconds ago. Cleaning now.");
                if (!touch($lastCleanFile)) {
                    $this->error("Could not create cache clean timestamp file.");
                }
                $files = glob($this->cacheDirectory . '/*' . FILE_CACHE_SUFFIX);
                if ($files) {
                    $timeAgo = time() - FILE_CACHE_MAX_FILE_AGE;
                    foreach ($files as $file) {
                        if (@filemtime($file) < $timeAgo) {
                            $this->debug(3, "Deleting cache file $file older than max age: " . FILE_CACHE_MAX_FILE_AGE . " seconds");
                            @unlink($file);
                        }
                    }
                }
                return TRUE;
            } else {
                $this->debug(3, "Cache was cleaned less than " . FILE_CACHE_TIME_BETWEEN_CLEANS . " seconds ago so no cleaning needed.");
            }
            return FALSE;
        }

        protected function processImageAndWriteToCache($localImage)
        {
            $sData = getimagesize($localImage);
            $origType = $sData[2];
            $mimeType = $sData['mime'];
            $this->debug(3, "Mime type of image is $mimeType");
            if (!preg_match('/^image\/(?:gif|jpg|jpeg|png)$/i', $mimeType)) {
                return $this->error("The image being resized is not a valid gif, jpg or png.");
            }
            if (!function_exists('imagecreatetruecolor')) {
                return $this->error('GD Library Error: imagecreatetruecolor does not exist - please contact your webhost and ask them to install the GD library');
            }
            if (function_exists('imagefilter') && defined('IMG_FILTER_NEGATE')) {
                $imageFilters = array(
                    1 => array(
                        IMG_FILTER_NEGATE,
                        0
                    ),
                    2 => array(
                        IMG_FILTER_GRAYSCALE,
                        0
                    ),
                    3 => array(
                        IMG_FILTER_BRIGHTNESS,
                        1
                    ),
                    4 => array(
                        IMG_FILTER_CONTRAST,
                        1
                    ),
                    5 => array(
                        IMG_FILTER_COLORIZE,
                        4
                    ),
                    6 => array(
                        IMG_FILTER_EDGEDETECT,
                        0
                    ),
                    7 => array(
                        IMG_FILTER_EMBOSS,
                        0
                    ),
                    8 => array(
                        IMG_FILTER_GAUSSIAN_BLUR,
                        0
                    ),
                    9 => array(
                        IMG_FILTER_SELECTIVE_BLUR,
                        0
                    ),
                    10 => array(
                        IMG_FILTER_MEAN_REMOVAL,
                        0
                    ),
                    11 => array(
                        IMG_FILTER_SMOOTH,
                        0
                    )
                );
            }
            $new_width = (int)abs($this->param('w', 0));
            $new_height = (int)abs($this->param('h', 0));
            $zoom_crop = (int)$this->param('zc', DEFAULT_ZC);
            $quality = (int)abs($this->param('q', DEFAULT_Q));
            $align = $this->cropTop ? 't' : $this->param('a', 'c');
            $filters = $this->param('f', DEFAULT_F);
            $sharpen = (bool)$this->param('s', DEFAULT_S);
            $canvas_color = $this->param('cc', DEFAULT_CC);
            $canvas_trans = (bool)$this->param('ct', '1');
            if ($new_width == 0 && $new_height == 0) {
                $new_width = (int)DEFAULT_WIDTH;
                $new_height = (int)DEFAULT_HEIGHT;
            }
            $new_width = min($new_width, MAX_WIDTH);
            $new_height = min($new_height, MAX_HEIGHT);
            $image = $this->openImage($mimeType, $localImage);
            if ($image === FALSE) {
                return $this->error('Unable to open image.');
            }
            $width = imagesx($image);
            $height = imagesy($image);
            $origin_x = 0;
            $origin_y = 0;
            if ($new_width && !$new_height) {
                $new_height = floor($height * ($new_width / $width));
            } else {
                if ($new_height && !$new_width) {
                    $new_width = floor($width * ($new_height / $height));
                }
            }
            if ($zoom_crop == 3) {
                $final_height = $height * ($new_width / $width);
                if ($final_height > $new_height) {
                    $new_width = $width * ($new_height / $height);
                } else {
                    $new_height = $final_height;
                }
            }
            $canvas = imagecreatetruecolor($new_width, $new_height);
            imagealphablending($canvas, FALSE);
            if (strlen($canvas_color) == 3) {
                $canvas_color = str_repeat(substr($canvas_color, 0, 1), 2) . str_repeat(substr($canvas_color, 1, 1), 2) . str_repeat(substr($canvas_color, 2, 1), 2);
            } else {
                if (strlen($canvas_color) != 6) {
                    $canvas_color = DEFAULT_CC;
                }
            }
            $canvas_color_R = hexdec(substr($canvas_color, 0, 2));
            $canvas_color_G = hexdec(substr($canvas_color, 2, 2));
            $canvas_color_B = hexdec(substr($canvas_color, 4, 2));
            if (preg_match('/^image\/png$/i', $mimeType) && !PNG_IS_TRANSPARENT && $canvas_trans) {
                $color = imagecolorallocatealpha($canvas, $canvas_color_R, $canvas_color_G, $canvas_color_B, 127);
            } else {
                $color = imagecolorallocatealpha($canvas, $canvas_color_R, $canvas_color_G, $canvas_color_B, 0);
            }
            imagefill($canvas, 0, 0, $color);
            if ($zoom_crop == 2) {
                $final_height = $height * ($new_width / $width);
                if ($final_height > $new_height) {
                    $origin_x = $new_width / 2;
                    $new_width = $width * ($new_height / $height);
                    $origin_x = round($origin_x - ($new_width / 2));
                } else {
                    $origin_y = $new_height / 2;
                    $new_height = $final_height;
                    $origin_y = round($origin_y - ($new_height / 2));
                }
            }
            imagesavealpha($canvas, TRUE);
            if ($zoom_crop > 0) {
                $src_x = $src_y = 0;
                $src_w = $width;
                $src_h = $height;
                $cmp_x = $width / $new_width;
                $cmp_y = $height / $new_height;
                if ($cmp_x > $cmp_y) {
                    $src_w = round($width / $cmp_x * $cmp_y);
                    $src_x = round(($width - ($width / $cmp_x * $cmp_y)) / 2);
                } else {
                    if ($cmp_y > $cmp_x) {
                        $src_h = round($height / $cmp_y * $cmp_x);
                        $src_y = round(($height - ($height / $cmp_y * $cmp_x)) / 2);
                    }
                }
                if ($align) {
                    if (strpos($align, 't') !== FALSE) {
                        $src_y = 0;
                    }
                    if (strpos($align, 'b') !== FALSE) {
                        $src_y = $height - $src_h;
                    }
                    if (strpos($align, 'l') !== FALSE) {
                        $src_x = 0;
                    }
                    if (strpos($align, 'r') !== FALSE) {
                        $src_x = $width - $src_w;
                    }
                }
                imagecopyresampled($canvas, $image, $origin_x, $origin_y, $src_x, $src_y, $new_width, $new_height, $src_w, $src_h);
            } else {
                imagecopyresampled($canvas, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            }
            if ($filters != '' && function_exists('imagefilter') && defined('IMG_FILTER_NEGATE')) {
                $filterList = explode('|', $filters);
                foreach ($filterList as $fl) {
                    $filterSettings = explode(',', $fl);
                    if (isset($imageFilters[$filterSettings[0]])) {
                        for ($i = 0; $i < 4; $i++) {
                            if (!isset($filterSettings[$i])) {
                                $filterSettings[$i] = NULL;
                            } else {
                                $filterSettings[$i] = (int)$filterSettings[$i];
                            }
                        }
                        switch ($imageFilters[$filterSettings[0]][1]) {
                            case 1:
                                imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1]);
                                break;
                            case 2:
                                imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1], $filterSettings[2]);
                                break;
                            case 3:
                                imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1], $filterSettings[2], $filterSettings[3]);
                                break;
                            case 4:
                                imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1], $filterSettings[2], $filterSettings[3], $filterSettings[4]);
                                break;
                            default:
                                imagefilter($canvas, $imageFilters[$filterSettings[0]][0]);
                                break;
                        }
                    }
                }
            }
            if ($sharpen && function_exists('imageconvolution')) {
                $sharpenMatrix = array(
                    array(
                        -1,
                        -1,
                        -1
                    ),
                    array(
                        -1,
                        16,
                        -1
                    ),
                    array(
                        -1,
                        -1,
                        -1
                    )
                );
                $divisor = 8;
                $offset = 0;
                imageconvolution($canvas, $sharpenMatrix, $divisor, $offset);
            }
            if ((IMAGETYPE_PNG == $origType || IMAGETYPE_GIF == $origType) && function_exists('imageistruecolor') && !imageistruecolor($image) && imagecolortransparent($image) > 0) {
                imagetruecolortopalette($canvas, FALSE, imagecolorstotal($image));
            }
            $tempfile = tempnam($this->cacheDirectory, 'tmpimg_');
            if (preg_match('/^image\/(?:jpg|jpeg)$/i', $mimeType)) {
                $imgType = 'jpg';
                imagejpeg($canvas, $tempfile, $quality);
            } else {
                if (preg_match('/^image\/png$/i', $mimeType)) {
                    $imgType = 'png';
                    imagepng($canvas, $tempfile, floor($quality * 0.09));
                } else {
                    if (preg_match('/^image\/gif$/i', $mimeType)) {
                        $imgType = 'gif';
                        imagegif($canvas, $tempfile);
                    } else {
                        return $this->sanityFail("Could not match mime type after verifying it previously.");
                    }
                }
            }
            if ($imgType == 'png' && OPTIPNG_ENABLED && OPTIPNG_PATH && @is_file(OPTIPNG_PATH)) {
                $exec = OPTIPNG_PATH;
                $this->debug(3, "optipng'ing $tempfile");
                $presize = filesize($tempfile);
                $out = `$exec -o1 $tempfile`;
                clearstatcache();
                $aftersize = filesize($tempfile);
                $sizeDrop = $presize - $aftersize;
                if ($sizeDrop > 0) {
                    $this->debug(1, "optipng reduced size by $sizeDrop");
                } else {
                    if ($sizeDrop < 0) {
                        $this->debug(1, "optipng increased size! Difference was: $sizeDrop");
                    } else {
                        $this->debug(1, "optipng did not change image size.");
                    }
                }
            } else {
                if ($imgType == 'png' && PNGCRUSH_ENABLED && PNGCRUSH_PATH && @is_file(PNGCRUSH_PATH)) {
                    $exec = PNGCRUSH_PATH;
                    $tempfile2 = tempnam($this->cacheDirectory, 'tmpimg_');
                    $this->debug(3, "pngcrush'ing $tempfile to $tempfile2");
                    $out = `$exec $tempfile $tempfile2`;
                    if (is_file($tempfile2)) {
                        $sizeDrop = filesize($tempfile) - filesize($tempfile2);
                        if ($sizeDrop > 0) {
                            $this->debug(1, "pngcrush was succesful and gave a $sizeDrop byte size reduction");
                            $todel = $tempfile;
                            $tempfile = $tempfile2;
                        } else {
                            $this->debug(1, "pngcrush did not reduce file size. Difference was $sizeDrop bytes.");
                            $todel = $tempfile2;
                        }
                    } else {
                        $this->debug(3, "pngcrush failed with output: $out");
                        $todel = $tempfile2;
                    }
                    @unlink($todel);
                }
            }
            $this->debug(3, "Rewriting image with security header.");
            $tempfile4 = tempnam($this->cacheDirectory, 'tmpimg_');
            $context = stream_context_create();
            $fp = fopen($tempfile, 'r', 0, $context);
            file_put_contents($tempfile4, $this->filePrependSecurityBlock . $imgType . ' ?' . '>');
            file_put_contents($tempfile4, $fp, FILE_APPEND);
            fclose($fp);
            @unlink($tempfile);
            $this->debug(3, "Locking and replacing cache file.");
            $lockFile = $this->cachefile . '.lock';
            $fh = fopen($lockFile, 'w');
            if (!$fh) {
                return $this->error("Could not open the lockfile for writing an image.");
            }
            if (flock($fh, LOCK_EX)) {
                @unlink($this->cachefile);
                rename($tempfile4, $this->cachefile);
                flock($fh, LOCK_UN);
                fclose($fh);
                @unlink($lockFile);
            } else {
                fclose($fh);
                @unlink($lockFile);
                @unlink($tempfile4);
                return $this->error("Could not get a lock for writing.");
            }
            $this->debug(3, "Done image replace with security header. Cleaning up and running cleanCache()");
            imagedestroy($canvas);
            imagedestroy($image);
            return TRUE;
        }

        protected function calcDocRoot()
        {
            $docRoot = @$_SERVER['DOCUMENT_ROOT'];
            if (defined('LOCAL_FILE_BASE_DIRECTORY')) {
                $docRoot = LOCAL_FILE_BASE_DIRECTORY;
            }
            if (!isset($docRoot)) {
                $this->debug(3, "DOCUMENT_ROOT is not set. This is probably windows. Starting search 1.");
                if (isset($_SERVER['SCRIPT_FILENAME'])) {
                    $docRoot = str_replace('\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0 - strlen($_SERVER['PHP_SELF'])));
                    $this->debug(3, "Generated docRoot using SCRIPT_FILENAME and PHP_SELF as: $docRoot");
                }
            }
            if (!isset($docRoot)) {
                $this->debug(3, "DOCUMENT_ROOT still is not set. Starting search 2.");
                if (isset($_SERVER['PATH_TRANSLATED'])) {
                    $docRoot = str_replace('\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0 - strlen($_SERVER['PHP_SELF'])));
                    $this->debug(3, "Generated docRoot using PATH_TRANSLATED and PHP_SELF as: $docRoot");
                }
            }
            if ($docRoot && $_SERVER['DOCUMENT_ROOT'] != '/') {
                $docRoot = preg_replace('/\/$/', '', $docRoot);
            }
            $this->debug(3, "Doc root is: " . $docRoot);
            $this->docRoot = $docRoot;
        }

        protected function getLocalImagePath($src)
        {
            $src = ltrim($src, '/');
            if (!$this->docRoot) {
                $this->debug(3, "We have no document root set, so as a last resort, lets check if the image is in the current dir and serve that.");
                $file = preg_replace('/^.*?([^\/\\\\]+)$/', '$1', $src);
                if (is_file($file)) {
                    return $this->realpath($file);
                }
                return $this->error("Could not find your website document root and the file specified doesn't exist in resizer's directory. We don't support serving files outside resizer's directory without a document root for security reasons.");
            } else {
                if (!is_dir($this->docRoot)) {
                    $this->error("Server path does not exist. Ensure variable \$_SERVER['DOCUMENT_ROOT'] is set correctly");
                }
            }
            if (file_exists($this->docRoot . '/' . $src)) {
                $this->debug(3, "Found file as " . $this->docRoot . '/' . $src);
                $real = $this->realpath($this->docRoot . '/' . $src);
                if (stripos($real, $this->docRoot) === 0) {
                    return $real;
                } else {
                    $this->debug(1, "Security block: The file specified occurs outside the document root.");
                }
            }
            $absolute = $this->realpath('/' . $src);
            if ($absolute && file_exists($absolute)) {
                $this->debug(3, "Found absolute path: $absolute");
                if (!$this->docRoot) {
                    $this->sanityFail("docRoot not set when checking absolute path.");
                }
                if (stripos($absolute, $this->docRoot) === 0) {
                    return $absolute;
                } else {
                    $this->debug(1, "Security block: The file specified occurs outside the document root.");
                }
            }
            $base = $this->docRoot;
            if (strstr($_SERVER['SCRIPT_FILENAME'], ':')) {
                $sub_directories = explode('\\', str_replace($this->docRoot, '', $_SERVER['SCRIPT_FILENAME']));
            } else {
                $sub_directories = explode('/', str_replace($this->docRoot, '', $_SERVER['SCRIPT_FILENAME']));
            }
            foreach ($sub_directories as $sub) {
                $base .= $sub . '/';
                $this->debug(3, "Trying file as: " . $base . $src);
                if (file_exists($base . $src)) {
                    $this->debug(3, "Found file as: " . $base . $src);
                    $real = $this->realpath($base . $src);
                    if (stripos($real, $this->realpath($this->docRoot)) === 0) {
                        return $real;
                    } else {
                        $this->debug(1, "Security block: The file specified occurs outside the document root.");
                    }
                }
            }
            return FALSE;
        }

        protected function realpath($path)
        {
            $remove_relatives = '/\w+\/\.\.\//';
            while (preg_match($remove_relatives, $path)) {
                $path = preg_replace($remove_relatives, '', $path);
            }
            return preg_match('#^\.\./|/\.\./#', $path) ? realpath($path) : $path;
        }

        protected function toDelete($name)
        {
            $this->debug(3, "Scheduling file $name to delete on destruct.");
            $this->toDeletes[] = $name;
        }

        public static function curlWrite($h, $d)
        {
            fwrite(self::$curlFH, $d);
            self::$curlDataWritten += strlen($d);
            if (self::$curlDataWritten > MAX_FILE_SIZE) {
                return 0;
            } else {
                return strlen($d);
            }
        }

        protected function serveCacheFile()
        {
            $this->debug(3, "Serving {$this->cachefile}");
            if (!is_file($this->cachefile)) {
                $this->error("serveCacheFile called in resizer but we couldn't find the cached file.");
                return FALSE;
            }
            $fp = fopen($this->cachefile, 'rb');
            if (!$fp) {
                return $this->error("Could not open cachefile.");
            }
            fseek($fp, strlen($this->filePrependSecurityBlock), SEEK_SET);
            $imgType = fread($fp, 3);
            fseek($fp, 3, SEEK_CUR);
            if (ftell($fp) != strlen($this->filePrependSecurityBlock) + 6) {
                @unlink($this->cachefile);
                return $this->error("The cached image file seems to be corrupt.");
            }
            $imageDataSize = filesize($this->cachefile) - (strlen($this->filePrependSecurityBlock) + 6);
            $this->sendImageHeaders($imgType, $imageDataSize);
            $bytesSent = @fpassthru($fp);
            fclose($fp);
            if ($bytesSent > 0) {
                return TRUE;
            }
            $content = file_get_contents($this->cachefile);
            if ($content != FALSE) {
                $content = substr($content, strlen($this->filePrependSecurityBlock) + 6);
                echo $content;
                $this->debug(3, "Served using file_get_contents and echo");
                return TRUE;
            } else {
                $this->error("Cache file could not be loaded.");
                return FALSE;
            }
        }

        protected function sendImageHeaders($mimeType, $dataSize)
        {
            if (!preg_match('/^image\//i', $mimeType)) {
                $mimeType = 'image/' . $mimeType;
            }
            if (strtolower($mimeType) == 'image/jpg') {
                $mimeType = 'image/jpeg';
            }
            $gmdate_expires = gmdate('D, d M Y H:i:s', strtotime('now +10 days')) . ' GMT';
            $gmdate_modified = gmdate('D, d M Y H:i:s') . ' GMT';
            header('Content-Type: ' . $mimeType);
            header('Accept-Ranges: none');
            header('Last-Modified: ' . $gmdate_modified);
            header('Content-Length: ' . $dataSize);
            if (BROWSER_CACHE_DISABLE) {
                $this->debug(3, "Browser cache is disabled so setting non-caching headers.");
                header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
                header("Pragma: no-cache");
                header('Expires: ' . gmdate('D, d M Y H:i:s', time()));
            } else {
                $this->debug(3, "Browser caching is enabled");
                header('Cache-Control: max-age=' . BROWSER_CACHE_MAX_AGE . ', must-revalidate');
                header('Expires: ' . $gmdate_expires);
            }
            return TRUE;
        }

        protected function param($property, $default = '')
        {
            if (isset($_GET[$property])) {
                return $_GET[$property];
            } else {
                return $default;
            }
        }

        protected function openImage($mimeType, $src)
        {
            switch ($mimeType) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($src);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($src);
                    imagealphablending($image, TRUE);
                    imagesavealpha($image, TRUE);
                    break;
                case 'image/gif':
                    $image = imagecreatefromgif($src);
                    break;
                default:
                    $this->error("Unrecognised mimeType");
            }
            return $image;
        }

        protected function getIP()
        {
            $rem = @$_SERVER["REMOTE_ADDR"];
            $ff = @$_SERVER["HTTP_X_FORWARDED_FOR"];
            $ci = @$_SERVER["HTTP_CLIENT_IP"];
            if (preg_match('/^(?:192\.168|172\.16|10\.|127\.)/', $rem)) {
                if ($ff) {
                    return $ff;
                }
                if ($ci) {
                    return $ci;
                }
                return $rem;
            } else {
                if ($rem) {
                    return $rem;
                }
                if ($ff) {
                    return $ff;
                }
                if ($ci) {
                    return $ci;
                }
                return "UNKNOWN";
            }
        }

        protected function debug($level, $msg)
        {
            if (DEBUG_ON && $level <= DEBUG_LEVEL) {
                $execTime = sprintf('%.6f', microtime(TRUE) - $this->startTime);
                $tick = sprintf('%.6f', 0);
                if ($this->lastBenchTime > 0) {
                    $tick = sprintf('%.6f', microtime(TRUE) - $this->lastBenchTime);
                }
                $this->lastBenchTime = microtime(TRUE);
                error_log("resizer Debug line " . __LINE__ . " [$execTime : $tick]: $msg");
            }
        }

        protected function sanityFail($msg)
        {
            return $this->error("There is a problem in the resizer code. Message: Please report this error at <a href='https://github.com/mindsharestudios/resizer/issues'>resizer's issue tracking page</a>: $msg");
        }

        protected function getMimeType($file)
        {
            $info = getimagesize($file);
            if (is_array($info) && $info['mime']) {
                return $info['mime'];
            }
            return '';
        }

        protected static function returnBytes($size_str)
        {
            switch (substr($size_str, -1)) {
                case 'M':
                case 'm':
                    return (int)$size_str * 1048576;
                case 'K':
                case 'k':
                    return (int)$size_str * 1024;
                case 'G':
                case 'g':
                    return (int)$size_str * 1073741824;
                default:
                    return $size_str;
            }
        }

        protected function getURL($url, $tempfile)
        {
            $this->lastURLError = FALSE;
            $url = preg_replace('/ /', '%20', $url);
            if (function_exists('curl_init')) {
                $this->debug(3, "Curl is installed so using it to fetch URL.");
                self::$curlFH = fopen($tempfile, 'w');
                if (!self::$curlFH) {
                    $this->error("Could not open $tempfile for writing.");
                    return FALSE;
                }
                self::$curlDataWritten = 0;
                $this->debug(3, "Fetching url with curl: $url");
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_TIMEOUT, CURL_TIMEOUT);
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.122 Safari/534.30");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($curl, CURLOPT_HEADER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($curl, CURLOPT_WRITEFUNCTION, 'resizer::curlWrite');
                @curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
                @curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
                $curlResult = curl_exec($curl);
                fclose(self::$curlFH);
                $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                if ($httpStatus == 404) {
                    $this->set404();
                }
                if ($httpStatus == 302) {
                    $this->error("External Image is Redirecting. Try alternate image URL.");
                    return FALSE;
                }
                if ($curlResult) {
                    curl_close($curl);
                    return TRUE;
                } else {
                    $this->lastURLError = curl_error($curl);
                    curl_close($curl);
                    return FALSE;
                }
            } else {
                $img = @file_get_contents($url);
                if ($img === FALSE) {
                    $err = error_get_last();
                    if (is_array($err) && $err['message']) {
                        $this->lastURLError = $err['message'];
                    } else {
                        $this->lastURLError = $err;
                    }
                    if (preg_match('/404/', $this->lastURLError)) {
                        $this->set404();
                    }
                    return FALSE;
                }
                if (!file_put_contents($tempfile, $img)) {
                    $this->error("Could not write to $tempfile.");
                    return FALSE;
                }
                return TRUE;
            }
        }

        protected function serveImg($file)
        {
            $s = getimagesize($file);
            if (!($s && $s['mime'])) {
                return FALSE;
            }
            header('Content-Type: ' . $s['mime']);
            header('Content-Length: ' . filesize($file));
            header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
            header("Pragma: no-cache");
            $bytes = @readfile($file);
            if ($bytes > 0) {
                return TRUE;
            }
            $content = @file_get_contents($file);
            if ($content != FALSE) {
                echo $content;
                return TRUE;
            }
            return FALSE;
        }

        protected function set404()
        {
            $this->is404 = TRUE;
        }

        protected function is404()
        {
            return $this->is404;
        }
    }
}
endif;
resizer::start();