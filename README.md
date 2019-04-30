# Peeps
A chat bot to help you remember the people you meet and expand your professional network. Try out the version without Peeps Finder here: [daniele-peeps.herokuapp.com](https://daniele-peeps.herokuapp.com)

# Installation
1. Install [WAMP](http://www.wampserver.com/en/)
2. Set up a MySQL Database in any method of your choosing and change the corresponding parameters in the file `classes/dao.php` (the data access object class) to access your database
3. Set up your WAMP server by following the [getting started guide](http://www.wampserver.com/en/2011/11/15/start-with-wampserver/) and start the server on your localhost.

# Using the Peeps Finder
To use the Peeps Finder to automatically find information about a contact from the internet, you will need to clone a [separate repository](https://github.com/danielemoro/PeepsFinder) and run the python script "server.py" at the same time as this web server is running. The two processes will communicate using the files `peeps_finder_in.txt` and `peeps_finder_out.txt`.

To find a specific person, enter the key word "find", and the Peeps Finder should then respond with prompt and continue from there. When completed, the new contact information will be saved to the Peeps database and can then be accessed later.
