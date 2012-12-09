These two directories contain the two frontend applications. Please note that these must be run on a server that supports PHP.
1. Admin: This application is used to simply test the system and view the raw data. 
2. User: Similar to Admin, this application is the actual mobile web application to view the data. 

The PHP scripts include the mechanism to decide whether or not a spot is occupied given the stream of data. Please note that the directory pointing to data.xml is here and must be changed to support the desired setup. Also note that in these files, the node ID's are registered into an Array, which distinguishes them as either a transponder or a magnetometer.
