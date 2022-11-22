import React from "react";
import { useState } from "react";
import { BiChevronDown } from "react-icons/bi";
import { Link } from "@inertiajs/inertia-react";
//import CalIcon from "../assets/images/icons/10.png";
import { usePage } from "@inertiajs/inertia-react";

export const IconDiv = ({ img }) => {
    return (
        <div className="flex justify-center items-center bg-white rounded-xl w-12 h-12 shrink-0 shadow">
            <img src={img} alt="" />
        </div>
    );
};

export const SelectFilter = ({ icon, title, subtitle, children }) => {
    const [clicked, setClicked] = useState(false);
    return (
        <div className="select relative xl:border-r xl:px-5 md:px-3 mx-1  xl:mb-0 mb-2 2xl:text-base text-sm">
            <div
                onClick={() => setClicked(!clicked)}
                className="flex items-center justify-start cursor-pointer xl:mb-0 mb-3"
            >
                <div className="flex justify-center items-center bg-custom-slate-200 rounded-xl w-12 h-12 shrink-0">
                    {icon}
                </div>
                <div className="mx-3 whitespace-nowrap">{title}</div>
                <BiChevronDown
                    className={`w-5 h-5 transition-all duration-300 ${
                        clicked ? "rotate-180" : ""
                    }`}
                />
            </div>
            <div
                className={`xl:absolute xl:left-0 xl:top-24 rounded-xl bg-white xl:shadow-lg transition-all duration-300 w-full text-sm z-40  ${
                    clicked
                        ? "opacity-100 visible translate-y-0 max-h-96"
                        : "xl:opacity-0 xl:invisible xl:translate-y-10 max-h-0"
                }`}
            >
                {children}
            </div>
        </div>
    );
};

export const MainButton = ({ text, onClick }) => {
    return (
        <button
            onClick={onClick}
            className="bg-custom-blue shadow-lg shadow-custom-blue/[0.5] text-white py-3 px-8 rounded-lg"
        >
            {text}
        </button>
    );
};

export const CallButton = ({ onClick }) => {
    const { localizations } = usePage().props;
    return (
        <button
            onClick={onClick}
            className="relative bg-custom-blue shadow-lg shadow-custom-blue/[0.5] text-white py-3 px-10 rounded-lg ml-5 my-5"
        >
            <img
                className="absolute -left-10 top-1/2 -translate-y-1/2 "
                src="/client/assets/images/icons/10.png"
                alt=""
            />
            {__("client.call_request", localizations)}
        </button>
    );
};

export const Pagination = ({ data }) => {
    let links = function (links) {
        let rows = [];
        //links.shift();
        //links.splice(-1);
        {
            links.map(function (item, index) {
                if (index > 0 && index < links.length - 1) {
                    rows.push(
                        <Link
                            href={item.url}
                            className={item.active ? "mx-3" : "mx-3 opacity-50"}
                        >
                            {item.label}
                        </Link>
                    );
                }
            });
        }
        return rows.length > 1 ? rows : null;
    };

    let linksPrev = function (links) {
        let rowCount = 0;
        links.map(function (item, index) {
            if (index > 0 && index < links.length - 1) {
                rowCount++;
            }
        });
        return rowCount > 1 ? (
            <Link href={links[0].url}>
                <Arrow color="#2F3E51" rotate="90" />
                <Arrow color="#2F3E51" rotate="90" />
            </Link>
        ) : null;
    };
    let linksNext = function (links) {
        let rowCount = 0;
        links.map(function (item, index) {
            if (index > 0 && index < links.length - 1) {
                rowCount++;
            }
        });
        return rowCount > 1 ? (
            <Link href={links[links.length - 1].url}>
                <Arrow color="#2F3E51" rotate="-90" />
                <Arrow color="#2F3E51" rotate="-90" />
            </Link>
        ) : null;
    };
    return (
        <div className="flex justify-center py-10">
            {/*<button className="mx-3 ">1</button>
      <button className="mx-3 opacity-50">2</button>
      <button className="mx-3 opacity-50">3</button>
      <button className="mx-3 opacity-50">4</button>*/}
            {links(data)}
        </div>
    );
};
