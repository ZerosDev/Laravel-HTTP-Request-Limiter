# Installation

1. Download this package save to your local storage
2. Copy 'packages' folder into your Laravel project (root folder)
3. Add this line to your composer.json in the 'autoload' section
<pre><code>"autoload": {
        "psr-4": {
            "App\\": "app/",
            "ZerosDev\\RateLimiter\\": "packages/zerosdev/rate-limiter/src"
        }
    },</code></pre>
4. Run this composer command
<pre><code>composer dump-autoload</code></pre>
5. Open your 'config/app.php' and add this code into your 'providers' array
<pre><code>ZerosDev\RateLimiter\RateLimiterServiceProvider::class,</code></pre>
6. Add this code to your 'aliases' array in the same file
<pre><code>'ZerosRateLimiter' => ZerosDev\RateLimiter\RateLimiterFacade::class,</code></pre>
7. Copy 'app/Http/Middleware/RateLimiter.php' to your 'app/Http/Middleware' folder

# Basic of Usage

Open your 'app/Http/Middleware/RateLimiter.php' and set the **limit()**, **delay()** and **bind()** method. Here is the description about each method and the example code :

### limit()
This is the amount of how many request will be allowed. After the request reached the limit threshold, next request will be suspended. This method must have an integer value (min value: 1)

### delay()
This is the amount of how long the suspended request will be allowed again **in second**. This method must have an integer value (min value: 1)

### bind()
This method must have an instance of Illuminate\Http\Request value

## Example Code
<pre><code>$rateLimiter = ZerosRateLimiter::limit(3)->delay(1)->bind($request)</code></pre>

Then to check if request is allowed you can use **allowed()** method. This method will return **true** if request is allowed, and **false** if not allowed, ie :
<pre><code>if ( $rateLimiter->allowed() === false ) {
  abort(429, 'Too Many Request');
}</code></pre>
