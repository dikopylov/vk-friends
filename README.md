# VK Friends
View your friends and mutual friends in vk.com with public [VK API](https://vk.com/dev) and Laravel under Docker.

## Requirements
1. Composer

## Stack
1. Laravel
2. MySQL
3. Redis
4. Vue.js

## Installation

1. Build application
```shell
make build
```
2. [Create VK app](https://vk.com/editapp?act=create). An example can be seen [here](./docs/create-app.png) 
3. Set VK app settings parameter `Authorized redirect URI` to `http://localhost/vk/auth/verify`
4. Configure VK environment variables data from VK app settings
```shell
VK_CLIENT_ID=App_ID
VK_CLIENT_SECRET=Secure_Key
VK_REDIRECT_URI=http://localhost/vk/auth/verify
```
5. Run application
```shell
make up
```
6. Go to http://localhost/
