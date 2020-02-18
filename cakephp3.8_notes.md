# CakePHP 3.8 notes

Debugging Queries and ResultSets
Since the ORM now returns Collections and Entities, debugging these objects can be more complicated than in previous CakePHP versions. There are now various ways to inspect the data returned by the ORM.

debug($query) Shows the SQL and bound parameters, does not show results.
sql($query) Shows the final rendered SQL, but only when having DebugKit installed.
debug($query->all()) Shows the ResultSet properties (not the results).
debug($query->toList()) An easy way to show each of the results.
debug(iterator_to_array($query)) Shows query results in an array format.
debug(json_encode($query, JSON_PRETTY_PRINT)) More human readable results.
debug($query->first()) Show the properties of a single entity.
debug((string)$query->first()) Show the properties of a single entity as JSON.

