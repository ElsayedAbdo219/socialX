# Authenticating requests

To authenticate requests, include an **`Authorization`** header with the value **`"Bearer {YOUR_AUTH_KEY}"`**.

All authenticated endpoints are marked with a `requires authentication` badge in the documentation below.

You can retrieve your token by visiting <b>Login API</b>.<br>All APIs <b>Must</b> Request Json Response <b>Accept:application/json</b>.<br>APIs <b>May</b> request response json <b>Content-Type:application/json</b>.<br>All APIs <b>Must</b> have version Header <b>Api-Version:v1</b>.<br>All APIs <b>May</b> have locale Header <b>Accept-Language:ar</b>.<br>All APIs <b>Must</b> have API Key Header <b>Api-Key:XX</b>
