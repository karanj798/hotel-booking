# hotel-booking
Allows users to book hotels which are inserted into the database.

## Requirements
- `wampserver` (Windows)
- `LAMP stack` (Linux)

## Usage
### Windows  
```bash
git clone https://github.com/karanj798/hotel-booking.git C:\wamp\www
cd C:\wamp\www\hotel-booking\
mysql.exe -use hotel_db.sql -u [USERNAME] -p
```
Open `http://localhost:80/hotel-booking`

### Linux
```bash
git clone https://github.com/karanj798/hotel-booking.git \var\www\html
cd \var\www\html\hotel-booking\
mysql -u [USERNAME] -p database_name < hotel_db.sql
```
Open `http://localhost:80/hotel-booking`

## Live Demo
`https://bookmy-hotel.herokuapp.com/`
