
import Banner from '@/Components/Carousel/Banner'
import CardProduct from '@/Components/Cards/CardProduct'
import CarouselBanner from '@/Components/Carousel/CarouselBanner'
import SectionList from '@/Components/Sections/SectionList'

import Layout from '@/Layouts/Layout'
import { Head, usePage } from '@inertiajs/react'
import CarouselTop from './CarouselTop'
import GridProduct from '@/Components/Grids/GridProduct'
import CarouselSection from './CarouselSection'


export default function Home({ page, brands, carouselTop, bannersTop, bestSeller, bannersMedium, newProducts, bannersBottom, categoriesProductCount }) {

    return (
        <>
            <Head title={page.meta_title} />
            <Layout>
                <div className="container">
                    <div className="py-content grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-8 ">
                        <div className="col-span-1 md:col-span-2 ">
                            <CarouselTop images={carouselTop} />
                        </div>

                 
                    </div>
                 


                    <SectionList title={"Categorias"}>
                        <CarouselSection items={categoriesProductCount} searchType="categories[]" />
                    </SectionList>

                    <SectionList title={"Los recién llegados"}>
                        <div className=" py-2 relative">
                            <GridProduct>
                                {newProducts.map((item) => (
                                    <CardProduct key={item.id} product={item} productNew={true} />
                                ))}
                            </GridProduct>
                        </div>
                    </SectionList>

               

                   

                </div>


            </Layout>
        </>
    )
}
