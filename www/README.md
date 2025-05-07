Comments:
- task done on symfony 7
- DB structure is very simplified to save time
- environment configurations could probably be improved
- basic authorization via api key
- I didn't have time to test whether https/other authorizations


### API Endpoint
http://localhost:8008/api/v1/subscription?api_key=444447cfd7ebf5b6a311dbb5d8955555

### Request Body
```json
{
  "first_name": "Tom",
  "last_name": "Novak",
  "email": "tom.novak@gmail.com",
  "role": "student"
}