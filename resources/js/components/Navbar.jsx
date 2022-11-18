import React, { useState } from "react";
//import { Link, useLocation } from "react-router-dom";
import { Link, usePage } from '@inertiajs/inertia-react'
//import Logo from "../assets/images/logo/1.png";
//import { navigation } from "./Data";
import { TiHeartFullOutline } from "react-icons/ti";
import { FaGlobeAmericas } from "react-icons/fa";

const Navbar = () => {
  const [menu, setMenu] = useState(false);
  const { pathname, locales, currentLocale, locale_urls, localizations } = usePage().props;


    let _cart = localStorage.getItem("welldevelopment_favorite");
    let cart;
    if (_cart !== null) {
        cart = JSON.parse(_cart);
    } else cart = [];

    const [favoriteCount, setFavoriteCount] = useState(cart.length);

    const navigation = [
        {
            text: __('client.nav_home',localizations),
            link: route('client.home.index'),
        },
        {
            text: __('client.nav_flats',localizations),
            link: route('client.apartment.index'),
        },
        {
            text: __('client.nav_about',localizations),
            link: route('client.about.index'),
        },
        {
            text: __('client.nav_blog',localizations),
            link: route('client.blog.index'),
        },
        {
            text: __('client.nav_contact',localizations),
            link: route('client.contact.index'),
        },
    ];

  return (
    <header className="sticky left-0 top-0 w-full z-50 bg-white xl:text-base text-sm shadow">
      <div className="wrapper flex items-center justify-between py-5">
        <Link className="relative z-50" href={route('client.home.index')}>
          <img src="/client/assets/images/logo/1.png" alt="" />
        </Link>
        <ul className={`navList ${menu ? "show" : ""}`}>
          {navigation.map((item) => {
            return (
              <li key={item.link} className="inline-block mx-4">
                <Link
                  href={item.link}
                  className={`navLink bold ${
                    pathname === item.link ? "active" : ""
                  }`}
                >
                  {item.text}
                </Link>
              </li>
            );
          })}
        </ul>
        <div className="flex">
          <Link
            href={route("client.favorite.index")}
            className="relative flex items-center justify-center w-10 h-10 bg-custom-slate-200 rounded-lg"
          >
            <TiHeartFullOutline className="w-5 h-5" />
              {favoriteCount > 0 ?<button className="absolute -top-2 -right-2 bg-red-500 w-5 h-5 rounded-full text-xs text-white bold">
                  {favoriteCount}
            </button>: null}
          </Link>
          <div className="group relative flex items-center justify-center w-10 h-10 bg-custom-slate-200 rounded-lg ml-3 ">
            <FaGlobeAmericas className="w-4 h-4 z-20 group-hover:text-custom-blue" />
            <div className="absolute top-4 left-0 w-full bg-inherit text-xs text-center py-3 pt-5 leading-loose rounded-lg transition-all duration-300 origin-top opacity-0 scale-y-0 group-hover:scale-y-100 group-hover:opacity-100">
              {/*<a href="#">ქრთ</a>
              <a href="#">ENG</a>
              <a href="#">RUS</a>*/}

                {Object.keys(locales).map((name, index) => {
                    if (locales[name] !== currentLocale) {
                        return (
                            <a
                                key={index}
                                className={`opacity-30 block transition-all duration-300  px-2 `}
                                href={locale_urls[name]}
                            >
                                {name}
                            </a>
                        );
                    } else {
                        return (
                            <a
                                className={`opacity-100 block transition-all duration-300  px-2  `}
                                href="javascript:;"
                            >
                                {" "}
                                {name}
                            </a>
                        );
                    }
                })}
            </div>
          </div>
          <button
            onClick={() => setMenu(!menu)}
            className={` ${
              menu ? " clicked" : ""
            } menuBtn ml-3 lg:hidden relative`}
          >
            <div className="span"></div>
            <div className="span"></div>
            <div className="span"></div>
          </button>
        </div>
      </div>
    </header>
  );
};

export default Navbar;
