import express,{ Router } from "express";
import {Book} from '../schemma/book.mjs'

const router = Router()

router.post('/', async (req, res) => {
    try {
        if(!req.body.title || !req.body.author || !req.body.publishYear){
            return res.status(400).send('Title, author, and publish year are required');
        }
        console.log('hii');
        
        const newBook = new Book({
            title: req.body.title,
            author: req.body.author,
            publishYear: req.body.publishYear
        });
        const savedBook = await Book.create(newBook);
        return res.status(201).send(savedBook);
    } catch (error) {
        console.log('Error occurred', error);
        return res.status(500).send('Internal Server Error');
    }
})

router.put('/:id', async (req,res)=>{
    let {id} = req.params;
    try {
        if(!req.body.title || !req.body.author || !req.body.publishYear){
            return res.status(400).send('Title, author, and publish year are required');
        }
        const updatedbook = await Book.findByIdAndUpdate(id,req.body)
        if(!updatedbook)
            return res.status(400).send("Error to updated")
        else
            return res.status(202).send("Successfully updated")        
    } catch (error) {
         return res.status(500).send({message:`Internal Server Error ${error.value}`});
    }
})

router.delete('/:id', async (req,res)=>{
    let {id} = req.params;
    try {
        const deletebook = await Book.findByIdAndDelete(id)
        if (!deletebook) {
            res.status(400).send({message:"book not found and deleted"})
        } else {
            res.status(200).send({message:"Successfully deleted"})
        }
    } catch (error) {
        return res.status(500).send({message:"Error to delete"})
        
    }
})

router.get('/', async (req, res) => {
    try {
        const books = await Book.find();
        return res.status(200).send({
            data:books
    })
        
    } catch (error) {
        return res.status(400).send("Couldn't read the data from Mongodb",error)
    }
})

router.get("/:id", async (req,res)=>{
    let id = req.params.id;
    console.log(id);
    
    
    try {
        const book = await Book.findOne({_id:id})
        res.status(200).send(book)
        
    } catch (error) {
        res.status(409).send({message:"Error to find the data"})
        
    }


})

router.get('/',(req,res)=>{
   return res.status(201).send('Hello from root')
})

export default router;