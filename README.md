# ReVogue

> Revogue empowers users to breathe new life into their wardrobe treasures, while cultivating a community where fashion is sustainable. It's about reimagining the lifecycle of fashion, where your garments become the catalyst for incredible second-hand discoveries.

## Project Components

* [ER: Requirements Specification](https://git.fe.up.pt/lbaw/lbaw2324/lbaw23107/-/wikis/er)
* [EBD: Database Specification](https://git.fe.up.pt/lbaw/lbaw2324/lbaw23107/-/wikis/ebd)
* [EAP: Architecture Specification and Prototype](https://git.fe.up.pt/lbaw/lbaw2324/lbaw23107/-/wikis/eap)
* [PA: Product and Presentation](https://git.fe.up.pt/lbaw/lbaw2324/lbaw23107/-/wikis/pa)

## Artefacts Checklist

* The artefacts checklist is available at: [Google Sheet](https://docs.google.com/spreadsheets/d/1KJHTnrm4QXCuKkgCpW1QtOgYxvfV_7D6Sqph21BtQZc/edit#gid=1742390135)

## How to run the project

To run the project, we recommend using the `./dev.sh` command which initializes everthing for you. 

If for some reason you cannot use `./dev.sh`, you must start the database and the mail server using `docker-compose up -d`:
 - The database is accessible through `localhost:5432` and pgAdmin is exposed through `localhost:4321`;
 - The mail server exposes it's web ui through `localhost:8025` and the SMTP server exposed through `localhost:1025`

Then you should run the Laravel queue with `php artisan queue:listen --tries=1` and the Laravel web server with `php artisan serve`. Finally if you wish to have hot reloading you should run `npm install && npm run dev` or if want to build it just once do `npm install && npm run build`.

In order to use Stripe, you must also run the `./stripe_webhook.sh` which requires a Stripe account. If you wish to create a Stripe account for testing, you should edit `.env` to change the API key and the webhook secret. Note that you should also alter the publishable key on `checkout.ts`. 

You can also fallback to not using Stripe and using `Payment on Delivery` on Checkout.

## Project Credentials

### User 

Email: chloehall@example.com

Password: cenoura-cozida-321

### Admin

Email: joseph.waldor@revogue.com

Password: alface-torrada-149

### Stripe Testing Cards

[Stripe testing cards](https://stripe.com/docs/testing?testing-method=card-numbers)

## Team

* Rita Cachaldora, up202108798@g.uporto.pt
* Madalena Ye, up202108795@g.uporto.pt
* Tomás Ramos, up202108687@g.uporto.pt
* Luís Duarte, up202108734@g.uporto.pt

***
GROUP23107, 21/09/2021
