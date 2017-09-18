# Gulp by examples

Various Gulp configurations to serve as basis for your projects.

Expecting you have already installed _node.js_ and Gulp-cli `npm install -g gulp-cli` (as Administrator on Windows and might need `sudo` on OSX/Linux).

Always the same install with 

```
npm install
```

and run with 

```
gulp
```

(there may be more tasks to run, check descriptions for each config)


## 01-browserync

Browsersync automatically refreshing `.html` and `.css` files in the root folder.

_This is mainly the simplest example._


## 02-scss

Same as 01 but also compiling `index.css` from Sass (scss) in `index.scss`. Generating sourcemaps too.

Also Browsersync server runs on different port.

_Again more of an example for learning._ 


## 03-advanced-css-compiling

Same as 02 but resulting CSS  

- is autoprefixed for vendor prefixes
- and some flexbox bugs are fixed 
- and minified in the end

Also for Browsersync
- server is set to try `/example.html` when `/example` is required.
- watches any html file (including those in subfolders) 

_This might be able to serve as a production ready code basis._ 


## 04-folders

Same as 03 but let's keep things more organized with folders.

`/src/static/` contains files that will be just copied as they are to the root of the website

`/src/scss/` contains all scss source files to be compiled to css

`/dist/` is created by gulp and contains the completed website and can be uploaded anywhere 

_This could be used to create a static website from scratch._


## 05-deployment

Same as 04 but with added option to deploy directly with gulp to [surge.sh](https://surge.sh).

### What is required for the deployment to be working

1. Install surge client `npm install --global surge`.
1. Run `surge` manually once in `/dist`: you will create an account with surge.sh.
1. Set your own domain in `gulpfile.js` (replace `https://domainofyourchoice.surge.sh`).
1. From now on run `gulp deploy` whenever you want to publish a new version.

If you want multiple people to be able to deploy to the same domain, run `surge --add mail.your.collaborator.used.to.register.with.surge@example.com` for each.


## 06-php-backend

Same as 04 but instead of using static HTML files it proxies another server running on http://localhost:8080/ and watches for changes in PHP files. 

You need to have this server up and running correctly before starting gulp.

In this case only static files and scss are moved to `/dist/` folder. PHP files are not moved there.