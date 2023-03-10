import React, { useState, useRef } from "react";
import { BsCheck } from "react-icons/bs";
import SingleSlider from "../components/SingleSlider";
import { IoLocationSharp } from "react-icons/io5";
import { CallButton, IconDiv } from "../components/Shared";
import { CiSearch } from "react-icons/ci";
import { TiHeartFullOutline } from "react-icons/ti";
import { ProjectSlider2 } from "../components/ProjectSlider";
import CallPopup from "../components/CallPopup";
import Layout from "../Layouts/Layout";
import { Link, usePage } from "@inertiajs/inertia-react";
import { Inertia } from "@inertiajs/inertia";
import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation, Pagination } from "swiper";
import { HiArrowRight, HiArrowLeft } from "react-icons/hi";

const SingleApartment = ({ seo }) => {
    const [showPopup, setShowPopup] = useState(false);

    const {
        project_apartments,
        similar_apartments,
        apartment,
        localizations,
        info,
    } = usePage().props;

    console.log(project_apartments, similar_apartments, apartment);

    let _cart = localStorage.getItem("welldevelopment_favorite");
    let cart;
    if (_cart !== null) {
        cart = JSON.parse(_cart);
    } else cart = [];

    let product_id = [];

    cart.map((item, index) => {
        product_id.push(item.product.id);
    });

    const [favorite, setFavorite] = useState(product_id.includes(apartment.id));

    const renderHTML = (rawHTML) =>
        React.createElement("p", {
            dangerouslySetInnerHTML: { __html: rawHTML },
        });

    const addToFavorite = function (product) {
        //localStorage.removeItem('cart')
        let _cart = localStorage.getItem("welldevelopment_favorite");
        let cart;
        if (_cart !== null) {
            cart = JSON.parse(_cart);
        } else cart = [];

        let product_id = [];

        cart.map((item, index) => {
            product_id.push(item.product.id);
        });

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
        console.log(
            JSON.parse(localStorage.getItem("welldevelopment_favorite"))
        );
        //localStorage.removeItem('cart')
        Inertia.visit(window.location.href);
    };
    const [showSlider, setShowSlider] = useState(false);
    const prevRef = useRef(null);
    const nextRef = useRef(null);
    return (
        <Layout seo={seo}>
            <div className="wrapper py-5">
                <div
                    className={`aptShowcase w-full relative transition-all duration-500 ${
                        showSlider ? "slider" : ""
                    }`}
                >
                    <Swiper
                        loop
                        navigation={true}
                        pagination={true}
                        modules={[Navigation, Pagination]}
                        className={`${
                            showSlider
                                ? "opacity-100 visible"
                                : "opacity-0 invisible"
                        } h-full w-full transition-all duration-500`}
                        onInit={(swiper) => {
                            swiper.params.navigation.prevEl = prevRef.current;
                            swiper.params.navigation.nextEl = nextRef.current;
                            swiper.navigation.init();
                            swiper.navigation.update();
                        }}
                    >
                        {apartment.project.cover_slider.map((item, index) => {
                            return (
                                <SwiperSlide
                                    key={index}
                                    className="w-full h-full"
                                >
                                    <img
                                        className="w-full h-full object-cover absolute left-0 top-0 -z-10"
                                        src={
                                            apartment.project.cover_slider
                                                .length > 0
                                                ? item.full_url
                                                : null
                                        }
                                        alt=""
                                    />
                                </SwiperSlide>
                            );
                        })}
                        <div className="absolute left-0 top-1/2 -translate-y-1/2 w-full px-5 flex justify-between items-center z-20">
                            <button
                                ref={prevRef}
                                className="lg:w-12 lg:h-12 w-8 h-8 flex items-center justify-center bg-white/[0.7] rounded-md"
                            >
                                <HiArrowLeft className="w-6 h-6" />
                            </button>
                            <button
                                ref={nextRef}
                                className="lg:w-12 lg:h-12 w-8 h-8 flex items-center justify-center bg-white/[0.7] rounded-md  xl:ml-6 ml-4"
                            >
                                <HiArrowRight className="w-6 h-6" />
                            </button>
                        </div>
                    </Swiper>
                    <img
                        className="w-full h-full object-cover absolute left-0 top-0 -z-10"
                        src={
                            apartment.project.cover_slider.length > 0
                                ? apartment.project.cover_slider[0].full_url
                                : null
                        }
                        alt=""
                    />
                    <div
                        className="absolute left-0 top-0 w-full h-full"
                        style={{
                            background:
                                "linear-gradient(to top ,#0036567c, transparent )",
                        }}
                    ></div>
                    <div className="max-w-7xl w-full absolute md:bottom-10 bottom-5 left-1/2 -translate-x-1/2 bold sm:text-lg text-white flex justify-start items-end 2xl:pl-0 pl-5 z-20">
                        <span> {apartment.project.title}</span>
                        <button
                            onClick={() => setShowSlider(!showSlider)}
                            className="flex justify-center items-center bg-white rounded-xl w-10 h-10 shrink-0 text-black -mb-2 ml-4 text-2xl"
                        >
                            <CiSearch />
                        </button>
                    </div>
                </div>
                <div className="max-w-7xl mx-auto py-10">
                    <div className="flex mb-10 justify-start">
                        <div>
                            <div className="bold">{apartment.title}</div>
                            <p className="opacity-50 text-sm">
                                {apartment.project.title}
                            </p>
                        </div>
                        <button
                            onClick={() => {
                                setFavorite(!favorite);
                                addToFavorite(apartment);
                            }}
                            className={`rounded-xl  shadow-md flex items-center justify-center w-10 h-10 bg-white shadow-lg ml-5  ${
                                favorite ? "text-red-500" : "text-gray-400"
                            } `}
                        >
                            <TiHeartFullOutline className="w-5 h-5" />
                        </button>
                    </div>
                    <section className="flex lg:flex-row flex-col items-start">
                        <div className="lg:w-1/2 lg:mr-16 mb-10 w-full">
                            <SingleSlider data={apartment.files} />
                            <div className="bold">
                                {apartment.project.title}
                            </div>
                            <p className="opacity-50 mt-2">
                                {" "}
                                <IoLocationSharp className="inline-block" />{" "}
                                {apartment.project.city
                                    ? apartment.project.city.title
                                    : null}
                                ,{" "}
                                {apartment.project.district
                                    ? apartment.project.district.title
                                    : null}
                                , {apartment.project.address}
                            </p>
                            <div className="flex text-center mt-10 text-sm flex-wrap">
                                <div className="mr-4 pr-4 mb-5 border-r">
                                    <p className="opacity-50 mb-2">
                                        {__("client.bedrooms", localizations)}
                                    </p>
                                    <p>
                                        <img
                                            className="inline-block mr-2"
                                            src="/client/assets/images/icons/7.png"
                                            alt=""
                                        />
                                        <span>{apartment.bedrooms}</span>
                                    </p>{" "}
                                </div>
                                <div className="mr-4 pr-4 mb-5 border-r">
                                    <p className="opacity-50 mb-2">
                                        {__("client.bathrooms", localizations)}
                                    </p>
                                    <p>
                                        <img
                                            className="inline-block mr-2"
                                            src="/client/assets/images/icons/8.png"
                                            alt=""
                                        />
                                        <span>{apartment.bathrooms}</span>
                                    </p>{" "}
                                </div>
                                <div className="mr-4 pr-4 mb-5 border-r">
                                    <p className="opacity-50 mb-2">
                                        {__("client.area", localizations)}
                                    </p>
                                    <p>
                                        <img
                                            className="inline-block mr-2"
                                            src="/client/assets/images/icons/9.png"
                                            alt=""
                                        />
                                        <span>{apartment.area} M</span>
                                    </p>
                                </div>
                                <div className="mb-5">
                                    <p className="opacity-50 mb-2">
                                        {__("client.floor", localizations)}
                                    </p>
                                    <p>
                                        <img
                                            className="inline-block mr-2"
                                            src="/client/assets/images/icons/11.png"
                                            alt=""
                                        />
                                        <select
                                            className="border px-2 rounded"
                                            name=""
                                            id=""
                                        >
                                            {apartment.floors.map(
                                                (item, index) => {
                                                    return (
                                                        <option value={item}>
                                                            {item}
                                                        </option>
                                                    );
                                                }
                                            )}
                                            {/*<option value="">5</option>
                                          <option value="">4</option>
                                          <option value="">3</option>*/}
                                        </select>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div className="max-w-lg">
                            <div className="mb-5">
                                {__("client.description", localizations)}
                            </div>
                            <p className="opacity-50 mb-5 border-b pb-5">
                                {renderHTML(apartment.description)}
                            </p>
                            <div className="mb-5">
                                {__("client.details", localizations)}
                            </div>
                            {apartment.details.map((item, index) => {
                                return (
                                    <p key={index} className="opacity-50 mb-5">
                                        <BsCheck className="inline-block text-custom-blue w-5 h-5 mr-2" />
                                        {item.title}
                                    </p>
                                );
                            })}
                            <button
                                onClick={() => {
                                    "";
                                }}
                            >
                                <CallButton
                                    onClick={() => setShowPopup(true)}
                                />
                            </button>
                            <p className="mt-5">
                                {__("client.or_contact_us", localizations)}:{" "}
                                <a href="tel:+995579904804">{info.phone}</a>
                            </p>
                        </div>
                    </section>
                </div>
                <section className="py-20">
                    <div className="bold text-lg mb-10">
                        {__("client.project_flats", localizations)}
                    </div>
                    <ProjectSlider2 items={project_apartments} />
                </section>
                <section className="pb-20">
                    <div className="bold text-lg mb-10">
                        {__("client.similar_flats", localizations)}
                    </div>
                    <ProjectSlider2 items={similar_apartments} />
                </section>
                <CallPopup show={showPopup} hide={() => setShowPopup(false)} />
            </div>
        </Layout>
    );
};

export default SingleApartment;
