Service workers can cache/precache the response of a given request. 
Let's say you have Library MySQL database on the server, containing tables like Books and Authors. 
In order to cache it using a service worker you could create a service that returns books 
and authors in JSON format, e.g. GET https://you-api.com/library. 

Then depending on your caching strategy you can either:
•	Add https://you-api.com/library URL to the list of precached resources used in service worker's install step, or
•	Handle service worker's fetch event corresponding to the https://you-api.com/library request.

In either case you can store the result in Cache or IndexedDB. I would prefer IndexedDB though, since we need to be able to work conveniently with this data later on. With IndexedDB you can create several stores if you decide to store your MySQL table records separately.
OK, we have created and populated our local database. Now what?

You could either:
•	Query local Library database directly from your page, or
•	Keep using service workers

Let's focus on the second option. Your app most likely uses some services to fetch data from the remote database. Let's say https://you-api.com/library/book/<id> service is used to retrieve a book by id. Why not take advantage of the fact that we have books cached locally? The most straightforward approach would be to:
•	Intercept fetch request corresponding to the URL above using service worker above
•	Read the table name and book id from the request URL
•	Query local Library database for that specific book and return it in the same format as the remote service would

Some additional considerations and corner cases:
•	Handle the case when local database is not present
•	Decide when and how the database is updated
•	Deal with schema changes
•	Optionally employ network first strategy. Attempt to retrieve database records from the remote service first and fallback to cached version when network is not available

