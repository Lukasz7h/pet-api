<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

API has been composed in Laravel v11 and deployed by docker.

Available urls:

URL: https://thriving-smile-production-7a7a.up.railway.app

GET

     https://thriving-smile-production-7a7a.up.railway.app/delete/ (Delete form)
     
     https://thriving-smile-production-7a7a.up.railway.app/add-pet/ (Add pet form)
     
     https://thriving-smile-production-7a7a.up.railway.app/update-pet/ (Update pet form)
     
     https://thriving-smile-production-7a7a.up.railway.app/pet/{id}/ (Return pet with mentioned id)
     
     https://thriving-smile-production-7a7a.up.railway.app/pet/findByStatus/{status}/ (Return pets with mentioned status)


POST

     https://thriving-smile-production-7a7a.up.railway.app/update-pet/ (Swaps pet object)
     
     https://thriving-smile-production-7a7a.up.railway.app/add-pet/ (Adds new pet in store.)


DELETE

     https://thriving-smile-production-7a7a.up.railway.app/delete/ (Removes choosen pet)

     

Docker hub: https://hub.docker.com/repository/docker/lukasz625/pet-api/general

Below that link is available docker image base on which API was launched (host is railway.app). That image was composed via dockerfile which could be easy found in repository.

App prevents actions like clickjacking or overwhelm memory by enormous request amount (throttle and clickjacking middlewares).
