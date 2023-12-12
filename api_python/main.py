from fastapi import FastAPI

app = FastAPI()

@app.get("/")
def read_root():
    return {"Hello": "World"}

@app.post("/sendAPI")
async def recibir_datos_desde_laravel():
    return {"mensaje": "Datos recibidos correctamente"}
