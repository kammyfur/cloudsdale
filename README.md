# Project Cloudsdale

A website made in collaboration and for [Cloudburst](https://github.com/CloudburstSys). The website is not yet installable from the Twilight Package Manager, but may be added to the repositories when released.

> Some features of this website require the use of the nginx Web server and were not tested with another web server. Other web servers are unsupported and will not get technical support.

## API
As per Cloudburst's requirements, this project features a REST-ful API that allows you to control aspects of the website.

### Endpoints
The following endpoints are available on the API:
* Publicly accessible endpoints:
  * `pluralkit` (PluralKit data, read-only)
  * `projects` (projects list, read-only)
* Endpoints that require admin authentication:
  * `users` (add/remove administrators)
  * `project-manager` (projects list, read-write)
  * `pluralkit-config` (PluralKit data, read-write)

(visit `/api` on the live website for all available endpoints)

### Authentication
Authentication is made using the `pcdAdminToken` cookie, which is set when OAuth2 with GitHub is completed and the website confirmed the user is an allowed administrator.