<?php

/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 * 
 * This software is licensed under the MIT license.
 */

if (!preg_match('~^/ZendServer~', $_SERVER['REQUEST_URI'])) {
	header('Location: /ZendServer/');
	exit;
}

$documentRoot = '/opt/zray/gui/public';

$requestedPath = rtrim($documentRoot . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$requestedPath = str_replace('/ZendServer', '', $requestedPath);

$mimeTypes = array(
	'css'  => 'text/css',
	'js'   => 'text/javascript',
	'png'  => 'image/png',
	'ico'  => 'image/x-icon',
	'woff' => 'application/x-font-woff',
	'ttf'  => 'application/x-font-ttf'
);

if (file_exists($requestedPath) && is_file($requestedPath)) {
	$info = pathinfo($requestedPath);

	if (!array_key_exists($info['extension'], $mimeTypes)) {
		throw new \LogicException(sprintf('Extension %s is not mapped!', $info['extension']));
	}
	
	header(sprintf('Content-Type: %s', $mimeTypes[$info['extension']]));
	readfile($requestedPath);
	return;
}

require_once $documentRoot . '/index.php';
