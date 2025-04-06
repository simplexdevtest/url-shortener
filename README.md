## Practical Coding Challenges
Build a simple URL shortener using PHP and MySQL.

### Requirements:

* API Endpoint: /shorten
* Accepts a long URL and returns a shortened one.
* API Endpoint: /redirect/{short_code}
* Redirects users to the original URL.
* Store mappings in a MySQL table:
  short_urls (id, short_code, original_url, created_at)
* Ensure short codes are unique.
* Handle errors properly.

Example Request to /shorten:
```
{
    "long_url": "https://www.example.com/very-long-url"
}
```
Expected Response:
```
{
    "short_url": "https://yourdomain.com/abc123"
}
```
Example Redirect:
Visiting /redirect/abc123 should redirect to https://www.example.com/very-long-url.
##
Bonus Questions 
* How would you scale the URL shortener for millions of requests per day?
* How would you cache API responses for performance optimization?
