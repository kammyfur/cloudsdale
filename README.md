# Project Cloudsdale

A website made in collaboration and for [Cloudburst](https://github.com/CloudburstSys). The website is not yet installable from the Twilight Package Manager, but may be added to the repositories when released.

> Some features of this website require the use of the nginx Web server and were not tested with another web server. Other web servers are unsupported and will not get technical support.

## API
As per Cloudburst's requirements, this project features a REST-ful API that allows you to control aspects of the website.

### Endpoints
The following endpoints are available on the API:
  * `pluralkit` (PluralKit data, read-only)
  * `projects` (projects list, read-only)
  * `contact` (contact info)

(visit `/api` on the live website for all available endpoints)

Admin panel data is not accessible from the API for security reasons (the real reason is laziness). If you really need access to the data, you may parse it manually from the HTML code.