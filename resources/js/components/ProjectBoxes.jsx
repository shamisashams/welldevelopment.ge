import React from "react";
//import { Link } from "react-router-dom";
import { Link, usePage } from '@inertiajs/inertia-react';
import { CiSearch } from "react-icons/ci";
import { TiHeartFullOutline } from "react-icons/ti";
import { FaCalendarAlt } from "react-icons/fa";
//import Icon1 from "../assets/images/icons/7.png";
//import Icon2 from "../assets/images/icons/8.png";
//import Icon3 from "../assets/images/icons/9.png";
//import bgImg from "../assets/images/bg/4.png";
import { useState } from "react";
import { Inertia } from "@inertiajs/inertia";

export const ProjectBox = (props) => {
  const [favorite, setFavorite] = useState(props.favorite);

  const {localizations} = usePage().props;

    const addToFavorite = function (product) {
        //localStorage.removeItem('cart')
        let _cart = localStorage.getItem("welldevelopment_favorite");
        let cart;
        if (_cart !== null) {
            cart = JSON.parse(_cart);
        } else cart = [];

        // let qty = parseInt(document.getElementById("qty_add").value);

        if (cart.length > 0) {
            let exists = false;
            let index = 0;
            cart.forEach(function (el, i) {
                if (el.product.id === product.id) {
                    //el.qty += qty;
                    exists = true;
                    index = i;
                }
            });
            if (!exists) {
                let obj = {
                    product: product,
                    //qty: qty,
                };
                cart.push(obj);
            } else {
                cart.splice(index, 1);
            }
        } else {
            let obj = {
                product: product,
                //qty: qty,
            };
            cart.push(obj);
        }

        localStorage.setItem("welldevelopment_favorite", JSON.stringify(cart));
        console.log(JSON.parse(localStorage.getItem("welldevelopment_favorite")));
        //localStorage.removeItem('cart')
        Inertia.visit(window.location.href);
    };

  return (
    <Link href={props.link} className="h-full ">
      <div className="overflow-hidden rounded-2xl relative shadow-lg h-full bg-white">
        {props.active && (
          <button className="absolute left-3 top-3 text-white rounded-xl py-3 px-6 bg-green-400">
              {__('client.action',localizations)}
          </button>
        )}
        <button
          onClick={(event) => {
              //event.stopImmediatePropagation()
              setFavorite(!favorite);
              addToFavorite(props.product)

          }}
          className={`absolute top-3 right-3 rounded-xl  shadow-md flex items-center justify-center w-10 h-10 bg-white  ${
            favorite ? "text-red-500" : "text-gray-400"
          } `}
        >
          <TiHeartFullOutline className="w-5 h-5" />
        </button>
        <div
          className="h-52 overflow-hidden rounded-xl mb-4 bg-cover bg-center"
          style={{ backgroundImage: `url('/client/assets/images/bg/4.png')` }}
        >
          <img
            className="w-full h-full object-contain"
            src={props.img}
            alt=""
          />
        </div>
        <div className="p-4 pb-5">
          <div className="bold">{props.title}</div>
          <p className="my-2 opacity-50">{props.para}</p>
          <div className="flex mt-5">
            <div className="bg-custom-slate-200 flex items-center py-1 px-5 rounded-xl mr-3">
              <img className="mr-2" src="/client/assets/images/icons/7.png" alt="" />
              <span>{props.bedroom}</span>
            </div>
            <div className="bg-custom-slate-200 flex items-center py-1 px-5 rounded-xl mr-3">
              <img className="mr-2" src="/client/assets/images/icons/8.png" alt="" />
              <span>{props.bathroom}</span>
            </div>
            <div className="bg-custom-slate-200 flex items-center py-1 px-5 rounded-xl mr-3">
              <img className="mr-2" src="/client/assets/images/icons/9.png" alt="" />
              <span>{props.dimension}</span>
            </div>
          </div>
        </div>
      </div>
    </Link>
  );
};

export const ActiveProject = ({ link, img, name }) => {
  return (
    <Link href={link} className="w-full group navLink">
      <div className="relative w-full h-72">
        <img
          className="w-full h-full object-contain align-bottom transition-all duration-300 group-hover:scale-110"
          src={img}
          alt=""
        />
        <CiSearch className="absolute text-white left-1/2 top-1/2 -translate-x-1/2  w-10 h-10 translate-y-1/2 group-hover:-translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300" />
      </div>
      <div className="bold relative text-center mt-8 group-hover:text-custom-blue transition-all duration-300 ">
        {name}
      </div>
    </Link>
  );
};

export const BlogBox = (props) => {
    const {localizations} = usePage().props;
  return (
    <div className="overflow-hidden rounded-2xl relative shadow-lg h-full bg-white">
      <div className="h-52 overflow-hidden rounded-xl mb-4">
        <img className="w-full h-full object-cover" src={props.img} alt="" />
      </div>
      <div className="p-4 pb-5">
        <div className="bold">{props.title}</div>
        <div className="opacity-50 text-sm mt-1 mb-5">
          <FaCalendarAlt className="inline-block mr-1 mb-1" /> {props.date}
        </div>
        <p className="my-2 opacity-50">{props.para}</p>
        <div className="flex justify-end mt-5">
          <Link
            href={props.link}
            className="bg-custom-slate-200 py-3 px-5 rounded-xl text-custom-blue"
          >
              {__('client.learn_more',localizations)}
          </Link>
        </div>
      </div>
    </div>
  );
};
