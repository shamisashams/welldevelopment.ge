import React from "react";
import Filters from "../components/Filters";
import { Pagination } from "../components/Shared";
import { projects } from "../components/Data";
import { ProjectBox } from "../components/ProjectBoxes";
import Layout from "../Layouts/Layout";
import { Link, usePage } from '@inertiajs/inertia-react'
import {Inertia} from "@inertiajs/inertia";

const Apartments = ({seo}) => {

    const {apartments,localizations} = usePage().props;

    let _cart = localStorage.getItem("welldevelopment_favorite");
    let cart;
    if (_cart !== null) {
        cart = JSON.parse(_cart);
    } else cart = [];

    let product_id = [];

    cart.map((item,index) => {
        product_id.push(item.product.id)
    })

    console.log(product_id)

    let appliedFilters = {};
    let urlParams = new URLSearchParams(window.location.search);

    urlParams.forEach((value, index) => {
        appliedFilters[index] = value.split(",");
    });

    function search(){
        let params = [];

        for (let key in appliedFilters) {
            params.push(key + "=" + appliedFilters[key].join(","));
        }

        Inertia.visit(route('client.apartment.index') + "?" + params.join("&"));
    }

  return (
      <Layout seo={seo}>
          <>
              <section className="bg-custom-slate-300 ">
                  <div className="wrapper items-start flex py-5 flex-col xl:flex-row">
                      <Filters appliedFilters={appliedFilters} />
                      <button onClick={search} className="bg-custom-blue shadow-lg shadow-custom-blue/[0.5] text-white py-3 xl:w-1/4 w-full px-3 rounded-lg">
                          {__('client.search',localizations)}
                      </button>
                  </div>
              </section>
              <section className="wrapper py-10">
                  <div className="grid xl:grid-cols-4 lg:grid-cols-3 sm:grid-cols-2 gap-y-10 gap-x-5 pb-5">
                      {apartments.data.map((item, index) => {
                          let favorite = false;
                          if(product_id.includes(item.id)) favorite = true;
                          return (
                              <ProjectBox
                                  key={index}
                                  link={route('client.apartment.show',item.slug)}
                                  img={item.latest_image?item.latest_image.full_url:null}
                                  title={item.title}
                                  para={item.short_description}
                                  bedroom={item.bedrooms}
                                  bathroom={item.bathrooms}
                                  dimension={item.area + ' M'}
                                  active={item.action === 1 ? true:false}
                                  favorite={favorite}
                              />
                          );
                      })}
                  </div>
                  <Pagination data={apartments.links} />
              </section>
          </>
      </Layout>

  );
};

export default Apartments;
