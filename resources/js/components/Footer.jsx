import React from "react";
import { IconDiv } from "./Shared";
import { navigation } from "./Data";
//import Icon1 from "../assets/images/icons/1.png";
//import Icon2 from "../assets/images/icons/2.png";
//import Icon3 from "../assets/images/icons/3.png";
//import Icon4 from "../assets/images/icons/4.png";
//import Icon5 from "../assets/images/icons/5.png";
//import Icon6 from "../assets/images/icons/6.png";
//import { Link } from "react-router-dom";
import { Link, usePage } from '@inertiajs/inertia-react';

const Footer = () => {
    const {info} = usePage().props;
  return (
    <footer className="bg-custom-slate-300 py-10">
      <div className="wrapper flex items-start justify-between md:flex-row flex-col">
        <div className="mb-10">
          <a href="#" className="flex items-center justify-start mb-3">
            <IconDiv img="/client/assets/images/icons/1.png" />
            <span className="pl-4">{info.email}</span>
          </a>
          <a href="#" className="flex items-center justify-start mb-3">
            <IconDiv img="/client/assets/images/icons/2.png" />
            <span className="pl-4">{info.phone}</span>
          </a>
          <a href="#" className="flex items-center justify-start mb-3">
            <IconDiv img="/client/assets/images/icons/3.png" />
            <span className="pl-4">
              {info.address}
            </span>
          </a>
        </div>
        <div className="md:text-right md:w-auto w-full">
          <ul className="mb-6 xl:text-base text-sm">
            {navigation.map((item) => {
              return (
                <li key={item.link} className="inline-block mx-4">
                  <Link href={item.link} className={`navLink bold`}>
                    {item.text}
                  </Link>
                </li>
              );
            })}
          </ul>
          <p>დაგვიმეგობრდი სოციალურ ქსელებში</p>
          <div className="flex items-center md:justify-end justify-start mt-5">
            <a target="_blank" href={info.facebook}>
              <IconDiv img="/client/assets/images/icons/4.png" />
            </a>
            <a target="_blank" className="mx-5" href={info.instagram}>
              <IconDiv img="/client/assets/images/icons/5.png" />
            </a>
            <a target="_blank" href={info.linkedin}>
              <IconDiv img="/client/assets/images/icons/6.png" />
            </a>
          </div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
